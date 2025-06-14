<?php
/*
  Duplicator Pro Plugin
  Copyright (C) 2016, Snap Creek LLC
  website: snapcreek.com

  Duplicator Pro Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require_once(dirname(__FILE__) . '/../utilities/class.u.php');
require_once(dirname(__FILE__) . '/../utilities/class.utility.php');
require_once(DUP_PRO_U::$PLUGIN_DIRECTORY . '/classes/entities/class.json.entity.base.php');
require_once(DUP_PRO_U::$PLUGIN_DIRECTORY . '/classes/entities/class.package.template.entity.php');
require_once(DUP_PRO_U::$PLUGIN_DIRECTORY . '/classes/entities/class.system.global.entity.php');
require_once(DUP_PRO_U::$PLUGIN_DIRECTORY . '/lib/cron/csd_parser.php');

if (!class_exists('DUP_PRO_Schedule_Repeat_Types'))
{
    abstract class DUP_PRO_Schedule_Repeat_Types
    {
        const Daily = 0;
        const Weekly = 1;
        const Monthly = 2;
    }
}

if (!class_exists('DUP_PRO_Schedule_Days'))
{
    abstract class DUP_PRO_Schedule_Days
    {
        const Monday = 1;
        const Tuesday = 2;
        const Wednesday = 4;
        const Thursday = 8;
        const Friday = 16;
        const Saturday = 32;
        const Sunday = 64;
    }
}

if (!class_exists('DUP_PRO_Schedule_Entity'))
{
    /**
     * @copyright 2016 Snap Creek LLC
     */
    class DUP_PRO_Schedule_Entity extends DUP_PRO_JSON_Entity_Base
    {
        public $name = '';
        public $template_id = -1;
        public $start_ticks;
        public $repeat_type = DUP_PRO_Schedule_Repeat_Types::Weekly;
        public $active = true;
        public $next_run_time = -1;
        public $run_every = 1;
        public $weekly_days = 0;    // for now just using a single day but they can be bit encoded here
        public $day_of_month = 1;
        public $cron_string = '';
        public $last_run_time = -1;
        public $last_run_status = DUP_PRO_Package_Build_Outcome::FAILURE;
        public $times_run = 0;
        public $storage_ids;

        function __construct()
        {
            parent::__construct();
            $this->verifiers['name'] = new DUP_PRO_Required_Verifier("Name must not be blank");
          //  $this->start_ticks = time();
            
            $this->storage_ids = array();
            array_push($this->storage_ids, DUP_PRO_Virtual_Storage_IDs::Default_Local);
            
            $this->name = DUP_PRO_U::__('New Schedule');
        }

        // If it should run, queue up a package then update the run time
        public function process()
        {
            DUP_PRO_U::log("process");
            $now = time();

            if ($this->next_run_time != -1)
            {
                if ($this->active && ($this->next_run_time <= $now))
                {

                    $next_run_time_string = DUP_PRO_U::get_local_formatted_time_from_gmt_ticks($this->next_run_time);
                    $now_string = DUP_PRO_U::get_local_formatted_time_from_gmt_ticks($this->next_run_time);

                    DUP_PRO_U::log("NEXT RUN IS NOW! $next_run_time_string <= $now_string so trying to queue package");

                    $this->insert_new_package();                    
                    
                    $this->next_run_time = $this->get_next_run_time();
                    $this->save();

                    $next_run_time_string = DUP_PRO_U::get_local_formatted_time_from_gmt_ticks($this->next_run_time);
                    DUP_PRO_U::log("******PACKAGE JUST CREATED. UPDATED NEXT RUN TIME TO $next_run_time_string");
                }
                else
                {
                    DUP_PRO_U::log("active and runtime=$this->next_run_time >= $now");
                }
            }
        }

        public function copy_from_source_id($source_id)
        {
            
            /* @var $source_schedule DUP_PRO_Schedule_Entity */
            $source_schedule = self::get_by_id($source_id);
                   
            $this->active = $source_schedule->active;
            $this->cron_string = $source_schedule->cron_string;
            $this->day_of_month = $source_schedule->day_of_month;
            $this->last_run_status = $source_schedule->last_run_status;
            $this->name = sprintf(DUP_PRO_U::__('%1$s - Copy'), $source_schedule->name);
            //$this->last_run_time = $source_schedule->last_run_time;
            //$this->next_run_time = $source_schedule
            $this->repeat_type = $source_schedule->repeat_type;
            $this->run_every = $source_schedule->run_every;
            $this->start_ticks = $source_schedule->start_ticks;
            $this->storage_ids = $source_schedule->storage_ids; // Arrays are copied
            $this->template_id = $source_schedule->template_id;
            //$this->times_run;
            $this->weekly_days = $source_schedule->weekly_days;
            
        }
        
        public function insert_new_package($run_now = false)
        {
			global $wp_version;
            global $wpdb;

            DUP_PRO_U::log("Inserting new package for schedule $this->name");

            /* @var $schedule DUP_PRO_Schedule_Entity */
            $template = DUP_PRO_Package_Template_Entity::get_by_id($this->template_id);

            if ($template != null)
            {
                $package = new DUP_PRO_Package();

                $package->template_name = $template->name;
                                
				$dbversion = preg_replace('/[^0-9.].*/', '', DUP_PRO_Util::MysqlVariableValue('version'));
				$dbversion = is_null($dbversion) ? '- unknown -' : $dbversion;

				//PACKAGE
				$package->Created = date("Y-m-d H:i:s");
				$package->Version = DUPLICATOR_PRO_VERSION;
				$package->VersionOS = defined('PHP_OS') ? PHP_OS : 'unknown';
				$package->VersionWP = $wp_version;
				$package->VersionPHP = phpversion();
				$package->VersionDB = $dbversion;															
                $package->Name = $this->generate_package_name();
                $package->Hash = $package->make_hash();
                $package->NameHash = "{$package->Name}_{$package->Hash}";
                $package->Notes = sprintf(DUP_PRO_U::__('Created by schedule %1$s'), $this->name);
                if($run_now)
                {
                    $package->Type = DUP_PRO_PackageType::RUN_NOW;
                }
                else
                {
                    $package->Type = DUP_PRO_PackageType::SCHEDULED;
                }

                //ARCHIVE
                $package->Archive->PackDir = rtrim(DUPLICATOR_PRO_WPROOTPATH, '/');
                $package->Archive->Format = 'ZIP';
                $package->Archive->FilterOn = $template->archive_filter_on;
                $package->Archive->FilterDirs = $template->archive_filter_dirs;
                $package->Archive->FilterExts = $template->archive_filter_exts;
                $package->Archive->FilterFiles = $template->archive_filter_files;

                //INSTALLER
                $package->Installer->OptsDBHost = $template->installer_opts_db_host;
                $package->Installer->OptsDBName = $template->installer_opts_db_name;
                $package->Installer->OptsDBUser = $template->installer_opts_db_user;
                $package->Installer->OptsSSLAdmin = $template->installer_opts_ssl_admin;
                $package->Installer->OptsSSLLogin = $template->installer_opts_ssl_login;
                $package->Installer->OptsCacheWP = $template->installer_opts_cache_wp;
                $package->Installer->OptsCachePath = $template->installer_opts_cache_path;
                $package->Installer->OptsURLNew = $template->installer_opts_url_new;
				$package->Installer->OptsSecureOn = $template->installer_opts_secure_on;
				$package->Installer->OptsSecurePass = $template->installer_opts_secure_pass;
				$package->Installer->OptsSkipScan = $template->installer_opts_skip_scan;
				
				// CPANEL
				$package->Installer->OptsCPNLHost = $template->installer_opts_cpnl_host;
				$package->Installer->OptsCPNLUser = $template->installer_opts_cpnl_user;
				$package->Installer->OptsCPNLPass = $template->installer_opts_cpnl_pass;
				$package->Installer->OptsCPNLEnable = $template->installer_opts_cpnl_enable;
				$package->Installer->OptsCPNLConnect = false;
				//CPANEL DB
				//1 = Create New, 2 = Connect Remove
				$package->Installer->OptsCPNLDBAction = $template->installer_opts_cpnl_db_action;
				$package->Installer->OptsCPNLDBHost = $template->installer_opts_cpnl_db_host;
				$package->Installer->OptsCPNLDBName = $template->installer_opts_cpnl_db_name;
				$package->Installer->OptsCPNLDBUser = $template->installer_opts_cpnl_db_user;

                //DATABASE
                $package->Database->FilterOn = $template->database_filter_on;
                $package->Database->FilterTables = $template->database_filter_tables;

                $package->Status = DUP_PRO_PackageStatus::PRE_PROCESS;
                
                $package->schedule_id = $this->id;

                $package->add_upload_infos($this->storage_ids);

                //$packageObj = serialize($package);
                $packageObj = json_encode($package);
				
				/* @var $system_global DUP_PRO_System_Global_Entity */
				$system_global = DUP_PRO_System_Global_Entity::get_instance();
								
				$system_global->clear_recommended_fixes();
				$system_global->save();			

                $results = $wpdb->insert($wpdb->prefix . "duplicator_pro_packages", array(
                    'name' => $package->Name,
                    'hash' => $package->Hash,
                    'status' => DUP_PRO_PackageStatus::PRE_PROCESS,
                    'created' => current_time('mysql'/*, get_option('gmt_offset', 1)*/),
                    'owner' => DUP_PRO_U::__('System'),
                    'package' => $packageObj)
                );
                                
                if ($results == false)
                {
                    $error_result = $wpdb->print_error();
                    DUP_PRO_Log::Error("Duplicator is unable to insert a package record into the database table.", "'{$error_result}'");
                }                               
            }
            else
            {
                $name = isset($schedule->name) ? $schedule->name : '';
                DUP_PRO_U::log_error("No settings object exists for schedule {$name}!");
            }
        }

        private function generate_package_name()
        {
            $ticks = time();
            $ticks += ((int) get_option('gmt_offset') * 3600);

            //Remove specail_chars from final result
            $special_chars = array(".", "-");
            $name = date('Y-m-d_H-i-s', $ticks) . '_' . $this->name . '_' . sanitize_title(get_bloginfo('name', 'display'));
            $name = substr(sanitize_file_name($name), 0, 40);
            $name = str_replace($special_chars, '', $name);
            return $name;
        }

        public function save()
        {
            DUP_PRO_U::log("saving schedule $this->id");
            // If we are inactive clear out any packages associated with us
			
            parent::save();
        }

        // Return the next run time in UTC
        public function get_next_run_time()
        {
            if ($this->active)
            {
                $now = time();

                // DUP_PRO_U::debug("now in GMT=" . DUP_PRO_U::get_standard_formatted_time($now));

                $now += (int) get_option('gmt_offset') * 3600;
                $now += 60;

                //     DUP_PRO_U::debug("Getting next time to run based on cron string $this->cron_string using base time of " . DUP_PRO_U::get_standard_formatted_time($now));
                $parser = new csd_parser($this->cron_string, $now);    // RSR was having problems with this - I THINK its because it considers when you are in the same minute as not really being the next but the same

                $next_run_time = $parser->get();

                //    DUP_PRO_U::debug("next run time in GMT = " . DUP_PRO_U::get_standard_formatted_time($next_run_time));
                $next_run_time -= ((int) get_option('gmt_offset') * 3600); // Have to negate the offset and add. For instance for az time -7 we want the next run timt to be 7 ahead in utc time
                //     DUP_PRO_U::debug("next run time in GMT which will run because of arizona time = " . DUP_PRO_U::get_standard_formatted_time($next_run_time));

                return $next_run_time;
            }
            else
            {
                return -1;
            }
        }

        public function set_weekdays_from_request($request)
        {
            $weekday = $request['weekday'];
            if (in_array('mon', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Monday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Monday;
            }

            if (in_array('tue', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Tuesday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Tuesday;
            }

            if (in_array('wed', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Wednesday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Wednesday;
            }

            if (in_array('thu', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Thursday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Thursday;
            }

            if (in_array('fri', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Friday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Friday;
            }

            if (in_array('sat', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Saturday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Saturday;
            }

            if (in_array('sun', $weekday))
            {
                $this->weekly_days |= DUP_PRO_Schedule_Days::Sunday;
            }
            else
            {
                $this->weekly_days &= ~DUP_PRO_Schedule_Days::Sunday;
            }
        }

        public function is_day_set($day_string)
        {
            $day_bit = 0;

            switch ($day_string)
            {
                case 'mon':
                    $day_bit = DUP_PRO_Schedule_Days::Monday;
                    break;

                case 'tue':
                    $day_bit = DUP_PRO_Schedule_Days::Tuesday;
                    break;

                case 'wed':
                    $day_bit = DUP_PRO_Schedule_Days::Wednesday;
                    break;

                case 'thu':
                    $day_bit = DUP_PRO_Schedule_Days::Thursday;
                    break;

                case 'fri':
                    $day_bit = DUP_PRO_Schedule_Days::Friday;
                    break;

                case 'sat':
                    $day_bit = DUP_PRO_Schedule_Days::Saturday;
                    break;

                case 'sun':
                    $day_bit = DUP_PRO_Schedule_Days::Sunday;
                    break;
            }

            $is_set = (($this->weekly_days & $day_bit) != 0);

            $isset_string = $is_set ? 'yes' : 'no';

            //DUP_PRO_U::debug("is_day_set:daystring=$day_string daybit=$day_bit)");
            // DUP_PRO_U::debug("is set = $isset_string");

            return $is_set;
        }

        public static function get_all()
        {
            return self::get_by_type(get_class());
        }

        public static function delete_by_id($list_id)
        {
            parent::delete_by_id_base($list_id);
        }

        public static function get_active()
        {
            $schedules = self::get_all();
            $active_schedules = array();

            foreach ($schedules as $schedule)
            {
                /* @var $schedule DUP_PRO_Schedule_Entity */
                if ($schedule->active)
                {
                    array_push($active_schedules, $schedule);
                }
            }
            return $active_schedules;
        }

        // [0] = hour; [1] = minute; 
        public function get_start_time_piece($piece)
        {
            switch ($piece)
            {
                case 0: return (int) date('G', $this->start_ticks);
                    break;

                case 1: return (int) date('i', $this->start_ticks);
                    break;

                default:
                    return -1;
            }
        }

        public function get_next_run_time_string()
        {
            if ($this->next_run_time == -1)
            {
                return DUP_PRO_U::__('Unscheduled');
            }
            else
            {
                $local_run_time = $this->next_run_time + ((int) get_option('gmt_offset') * 3600);

                $date_portion = date('n/j/y G:i', $local_run_time);
                $repeat_portion = $this->get_repeat_text();
                
                return "$date_portion - $repeat_portion";
            }
        }
        
        public function get_last_ran_string()
        {
            if ($this->last_run_time == -1)
            {
                return DUP_PRO_U::__('Never Ran');
            }
            else
            {
                $local_run_time = $this->last_run_time + ((int) get_option('gmt_offset') * 3600);

                $date_portion = date('n/j/y G:i', $local_run_time);                
                $status_portion = (($this->last_run_status == DUP_PRO_Package_Build_Outcome::SUCCESS) ? DUP_PRO_U::__('Success') : DUP_PRO_U::__('Failed'));
                
                return "$date_portion - $status_portion";
            }
        }

        public function set_start_date_time($start_time_string, $start_date_string = '2015/1/1')
        {
            $this->start_ticks = strtotime("$start_date_string $start_time_string");
            DUP_PRO_U::log("start ticks = $this->start_ticks for $start_time_string $start_date_string");
        }

        public static function get_by_id($id)
        {
            return self::get_by_id_and_type($id, get_class());
        }

        public static function get_by_template_id($template_id)
        {
            $schedules = self::get_all();
            $filtered_schedules = array();
            
            foreach($schedules as $schedule)
            {
                /* @var $schedule DUP_PRO_Schedule_Entity */
                if($schedule->template_id == $template_id)
                {
                    array_push($filtered_schedules, $schedule);
                }
            }
            
            DUP_PRO_U::log("get by template id $template_id schedules = " . count($filtered_schedules));
            
            return $filtered_schedules;
        }          
        
        public function get_repeat_text()
        {
            switch ($this->repeat_type)
            {
                case DUP_PRO_Schedule_Repeat_Types::Daily:
                    return DUP_PRO_U::__('Daily');
                    break;

                case DUP_PRO_Schedule_Repeat_Types::Weekly:
                    return DUP_PRO_U::__('Weekly');
                    break;

                case DUP_PRO_Schedule_Repeat_Types::Monthly:
                    return DUP_PRO_U::__('Monthly');
                    break;

                default:
                    return DUP_PRO_U::__('Unknown');
            }
        }

        public function build_cron_string()
        {
            // Special cron string for debugging if name set to 'bobtest'
            if ($this->name == 'bobtest')
            {
                $this->cron_string = '*/5 * * * *';
            }
            else
            {
                $start_hour = $this->get_start_time_piece(0);
                $start_min = $this->get_start_time_piece(1);

                if ($this->run_every == 1)
                {
                    $run_every_string = '*';
                }
                else
                {
                    $run_every_string = "*/$this->run_every";
                }

                // Generated cron patterns using http://www.cronmaker.com/
                switch ($this->repeat_type)
                {
                    case DUP_PRO_Schedule_Repeat_Types::Daily:
                        $this->cron_string = "$start_min $start_hour $run_every_string * *";
                        break;

                    case DUP_PRO_Schedule_Repeat_Types::Weekly:
                        $day_of_week_string = $this->get_day_of_week_string();
                        $this->cron_string = "$start_min $start_hour * * $day_of_week_string";

                        DUP_PRO_U::log("day of week cron string: $this->cron_string");
                        break;

                    case DUP_PRO_Schedule_Repeat_Types::Monthly:
                        $this->cron_string = "$start_min $start_hour $this->day_of_month $run_every_string *";
                        break;
                }
            }
            
            DUP_PRO_U::log("cron string = $this->cron_string");
        }

        private function get_day_of_week_string()
        {
            $day_array = array();

            DUP_PRO_U::log("weekly days=$this->weekly_days");


            if (($this->weekly_days & DUP_PRO_Schedule_Days::Monday) != 0)
            {
                array_push($day_array, '1');
            }

            if (($this->weekly_days & DUP_PRO_Schedule_Days::Tuesday) != 0)
            {
                array_push($day_array, '2');
            }

            if (($this->weekly_days & DUP_PRO_Schedule_Days::Wednesday) != 0)
            {
                array_push($day_array, '3');
            }

            if (($this->weekly_days & DUP_PRO_Schedule_Days::Thursday) != 0)
            {
                array_push($day_array, '4');
            }

            if (($this->weekly_days & DUP_PRO_Schedule_Days::Friday) != 0)
            {
                array_push($day_array, '5');
            }

            if (($this->weekly_days & DUP_PRO_Schedule_Days::Saturday) != 0)
            {
                array_push($day_array, '6');
            }

            if (($this->weekly_days & DUP_PRO_Schedule_Days::Sunday) != 0)
            {
                array_push($day_array, '0');
            }
            return implode(',', $day_array);
        }
    }
}
?>