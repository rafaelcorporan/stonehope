<?php
require_once(DUPLICATOR_PRO_PLUGIN_PATH . '/views/inc.header.php');
require_once(DUPLICATOR_PRO_PLUGIN_PATH . '/classes/entities/class.schedule.entity.php');

$nonce_action = 'duppro-schedule-list';
$display_edit = false;

if (isset($_REQUEST['action']))
{
    check_admin_referer($nonce_action);
    $action = $_REQUEST['action'];
    switch ($action)
    {   
        case 'add':
        case 'edit':
            $display_edit = true;
			break;
		
        case 'bulk-delete':
            $schedule_ids = $_REQUEST['selected_id'];
            foreach ($schedule_ids as $schedule_id)
            {
                DUP_PRO_Schedule_Entity::delete_by_id($schedule_id);
            }
            break;

        case 'delete':
            $schedule_id = (int) $_REQUEST['schedule_id'];
            DUP_PRO_Schedule_Entity::delete_by_id($schedule_id);
            break;
        
        default:
            break;
    }
}

$active_schedules = DUP_PRO_Schedule_Entity::get_active();
$active_count = count($active_schedules);

$schedules = DUP_PRO_Schedule_Entity::get_all();
$schedule_count = count($schedules);

$active_package = DUP_PRO_Package::get_next_active_package();
$active_schedule_id = -1;

if ($active_package != null)
{
    $active_schedule_id = $active_package->schedule_id;
}
?>

<style>
    /*Detail Tables */
    table.schedule-tbl td {height: 45px}
    table.schedule-tbl a.name {font-weight: bold}
    table.schedule-tbl input[type='checkbox'] {margin-left: 5px}
    table.schedule-tbl div.sub-menu {margin: 5px 0 0 2px; display: none}
    tr.schedule-detail {display: none;}
    tr.schedule-detail td {padding:2px 2px 2px 15px; margin:-5px 0 2px 0; height: 22px}
    td.dpro-no-data {text-align: center; background:#fff; padding:40px; line-height:30px}
</style>

<!-- ====================
TOOL-BAR -->
<table class="dpro-edit-toolbar">
    <tr>
        <td>
            <select id="bulk_action">
                <option value="-1" selected="selected"><?php _e("Bulk Actions"); ?></option>
                <option value="delete" title="Delete selected schedules(s)"><?php _e("Delete"); ?></option>
            </select>
            <input type="button" class="button action" value="<?php DUP_PRO_U::_e("Apply") ?>" onclick="DupPro.Schedule.BulkAction()">
        </td>
        <td>
            <span> <i class="fa fa-clock-o"></i> <?php DUP_PRO_U::_e("All Schedules"); ?></span>
            <a href="<?php echo $edit_schedule_url; ?>" class="add-new-h2"><?php DUP_PRO_U::_e("Add New"); ?></a>
        </td>
    </tr>
</table>

<form id="dup-schedule-form" action="<?php echo $schedules_tab_url; ?>" method="post">
    <?php wp_nonce_field($nonce_action); ?>
    <input type="hidden" id="dup-schedule-form-action" name="action" value=""/>
    <input type="hidden" id="dup-schedule-selected-schedule" name="schedule_id" value="-1"/>

    <!-- ====================
    LIST ALL SCHEDULES -->
    <table class="widefat schedule-tbl">
        <thead>
            <tr>
                <th style='width:10px;'><input type="checkbox" id="dpro-chk-all" title="Select all packages" onclick="DupPro.Schedule.SetDeleteAll(this)"></th>
                <th style='width:235px;'><?php DUP_PRO_U::_e('Name'); ?></th>
				<th><?php DUP_PRO_U::_e('Storage'); ?></th>
                <th><?php DUP_PRO_U::_e('Runs Next'); ?></th>
                <th><?php DUP_PRO_U::_e('Last Ran'); ?></th>
                <th><?php DUP_PRO_U::_e('Active'); ?></th>
            </tr>
        </thead>
        <tbody>
		<?php if ($schedule_count <= 0) : ?>
			<tr>
				<td colspan="6" class="dpro-no-data">
					<h2>
						<i class="fa fa-clock-o"></i> <?php DUP_PRO_U::_e('No Schedules Found') ?> <br/>
						<a href="<?php echo $edit_schedule_url; ?>">[<?php DUP_PRO_U::_e('Create New Schedule') ?>]</a>
					</h2>
				</td>
			</tr>
		<?php endif; ?>

		<?php
		$i = 0;
		foreach ($schedules as $schedule) :
			/* @var $schedule DUP_PRO_Schedule_Entity */
			$i++;
			$icon_display = (($schedule->id == $active_schedule_id) ? 'inline' : 'none');
			?>
			<tr class="schedule-row <?php echo ($i % 2) ? 'alternate' : ''; ?>">
				<td>
					<input name="selected_id[]" type="checkbox" value="<?php echo $schedule->id ?>" class="item-chk" />
				</td>
				<td style="p">
					<i id="<?php echo "icon-{$schedule->id}-status"; ?>" class="fa fa-gear fa-spin schedule-status-icon" style="display:<?php echo $icon_display; ?>; margin-right:4px;"></i>
					<a id="<?php echo "text-{$schedule->id}"; ?>" href="javascript:void(0);" onclick="DupPro.Schedule.Edit('<?php echo $schedule->id ?>');" class="name"><?php echo $schedule->name; ?></a>
					<div class="sub-menu">
						<a href="javascript:void(0);" onclick="DupPro.Schedule.QuickView('<?php echo $schedule->id ?>');"><?php DUP_PRO_U::_e('Quick View'); ?></a> |
						<a href="javascript:void(0);" onclick="DupPro.Schedule.Edit('<?php echo $schedule->id ?>');"><?php DUP_PRO_U::_e('Edit'); ?></a> |
						<a href="javascript:void(0);" onclick="DupPro.Schedule.Delete('<?php echo $schedule->id; ?>');"><?php DUP_PRO_U::_e('Delete'); ?></a> |
						<a href="javascript:void(0);" onclick="DupPro.Schedule.RunNow('<?php echo $schedule->id; ?>');"><?php DUP_PRO_U::_e('Run Now'); ?></a> 
					</div>
				</td>
				<td>					
					<?php 
					foreach($schedule->storage_ids as $storage_id)
					{
						/* @var $storage DUP_PRO_Storage_Entity */
						$storage = DUP_PRO_Storage_Entity::get_by_id($storage_id);
						
						echo $storage->name . '<br/>';
					}
					?>
				</td>
				<td><?php echo $schedule->get_next_run_time_string(); ?></td>
				<td id="schedule-<?php echo $schedule->id ?>-last-ran-string"><?php echo $schedule->get_last_ran_string(); ?></td>
				<td><?php $schedule->active ? DUP_PRO_U::_e('Yes') : DUP_PRO_U::_e('No'); ?></td>
			</tr>
			<tr id='detail-<?php echo $schedule->id ?>' class='<?php echo ($i % 2) ? 'alternate' : ''; ?> schedule-detail'>
				<td colspan="5">
					<?php
					$template = DUP_PRO_Package_Template_Entity::get_by_id($schedule->template_id);
					?>
					<table style="line-height: 15px">
						<tr>
							<td><b><?php echo DUP_PRO_U::__('Package Template:'); ?></b></td>
							<td colspan="3"><?php echo $template->name; ?></td>
						</tr>	
						<tr>
							<td><b><?php echo DUP_PRO_U::__('Summary:'); ?></b></td>
							<td colspan="3"><?php echo sprintf(DUP_PRO_U::__('Runs %1$s'), $schedule->get_repeat_text()); ?></td>
						</tr>							
						<tr>
							<td><b><?php echo DUP_PRO_U::__('Last Ran:') ?></b></td>
							<td><?php echo $schedule->get_last_ran_string(); ?></td>
						</tr>							
						<tr>
							<td><b><?php echo DUP_PRO_U::__('Times Run:')?></b></td>
							<td><?php echo $schedule->times_run; ?></td>
						</tr>
					</table>
				</td>
			</tr>
		<?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr >
                <th colspan="6"  style="text-align:right; white-space: nowrap; font-size:12px">						
					<?php 
						echo DUP_PRO_U::__('Total')  . ': ' . $schedule_count  . ' | '; 
						echo DUP_PRO_U::__('Active') . ': ' . $active_count    . ' | '; 
						echo DUP_PRO_U::__("Time")   . ': ' . '<span id="dpro-clock-container"></span>'; 
					?>
                </th>
            </tr>
        </tfoot>
    </table>
</form>

<script>
    jQuery(document).ready(function ($) {

        /*METHOD: Shows quick view summary */
        DupPro.Schedule.QuickView = function (id) {
            $('#detail-' + id).toggle();
        }

		/*METHOD: Run the schedule now and redirect to packages page */
        DupPro.Schedule.RunNow = function (schedule_id) {
            if (confirm("<?php DUP_PRO_U::_e('Run schedule now?') ?>"))
            {
				$('#icon-' + schedule_id + '-status').show();
				$('#text-' + schedule_id).html("<?php DUP_PRO_U::_e('Queueing Now - Please Wait...') ?>");
                var data = {
					action: 'duplicator_pro_run_schedule_now', 
					schedule_id: schedule_id
				}
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    dataType: "json",
                    timeout: 10000000,
                    data: data,
                    complete: function (data) {
                       window.location.href = "admin.php?page=duplicator-pro";
                    }
                });
            }
        }

		/*METHOD: Deletes a single schedule */
        DupPro.Schedule.Delete = function (id) {
            if (confirm("<?php DUP_PRO_U::_e('Are you sure you want to delete the selected items?') ?>"))
            {
                jQuery("#dup-schedule-form-action").val('delete');
                jQuery("#dup-schedule-selected-schedule").val(id);
                jQuery("#dup-schedule-form").submit();
            }
        }

		/*METHOD: Bulk action response */
        DupPro.Schedule.BulkAction = function () {
            var action = $('#bulk_action').val();
            var checked = ($('.item-chk:checked').length > 0);
            if(checked)
            {
                switch (action) {
                    case 'delete':
                        var message = "<?php DUP_PRO_U::_e('Delete the selected items?') ?>";
                        if (confirm(message))
                        {
                            jQuery("#dup-schedule-form-action").val('bulk-delete');
                            jQuery("#dup-schedule-form").submit();
                        }
                        break;
                }
            }
        }

        /*METHOD: Edit a single schedule */
        DupPro.Schedule.Edit = function (id) {
            document.location.href = '<?php echo "$edit_schedule_url&schedule_id="; ?>' + id;
        }

        /*METHOD: Set delete all */
        DupPro.Schedule.SetDeleteAll = function (chkbox) {
            $('.item-chk').each(function () {
                this.checked = chkbox.checked;
            });
        }

		/*METHOD: Enableds the update flag to track proccessing */
        DupPro.Schedule.SetUpdateInterval = function(period) {
            console.log('setting interval to '+ period);
            if(DupPro.Schedule.setIntervalID != -1) {
                clearInterval(DupPro.Schedule.setIntervalID);
                DupPro.Schedule.setIntervalID = -1
            }
            DupPro.Schedule.setIntervalID = setInterval(DupPro.Schedule.UpdateSchedules, period * 1000);
        }

		/*METHOD: Checks the schedule status */
        DupPro.Schedule.UpdateSchedules = function () {

            var data = {action: 'duplicator_pro_get_schedule_infos'};

            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                data: data,
                success: function (schedule_infos) {
                    activeSchedulePresent = false;
                    for(schedule_info_key in schedule_infos) 
					{
                        var schedule_info = schedule_infos[schedule_info_key];
                        var is_running_selector = "#icon-" + schedule_info.schedule_id + "-status";
                        var last_ran_selector = "#schedule-" + schedule_info.schedule_id + "-last-ran-string";
                        if (schedule_info.is_running) {
                            $(is_running_selector).show();
                            activeSchedulePresent = true;
                        } 
                        else {
                            $(is_running_selector).hide();
                        }
                        $(last_ran_selector).text(schedule_info.last_ran_string);
                    }
                    
                    if(activeSchedulePresent) {
                        DupPro.Schedule.SetUpdateInterval(10);                        
                    } else {
                        
                        DupPro.Schedule.SetUpdateInterval(60);
                    }                                                
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                    $(".schedule-status-icon").display('none');
                    DupPro.Schedule.SetUpdateInterval(60);
                }
            });
        }

        //INIT: startup items
        $("tr.schedule-row").hover(
                function () {$(this).find(".sub-menu").show();},
                function () {$(this).find(".sub-menu").hide();}
        );
	
		DupPro.UI.Clock(DupPro._WordPressInitTime);
        DupPro.Schedule.setIntervalID = -1;
        DupPro.Schedule.UpdateSchedules();
    });
</script>