<?php
if (!defined('DUPLICATOR_PRO_VERSION'))
	exit; // Exit if accessed directly
require_once (DUPLICATOR_PRO_PLUGIN_PATH . 'classes/class.package.archive.php');
require_once (DUPLICATOR_PRO_PLUGIN_PATH . 'classes/entities/class.global.entity.php');
require_once (DUPLICATOR_PRO_PLUGIN_PATH . 'classes/entities/class.system.global.entity.php');
/**
 *  DUP_PRO_ZIP
 *  Creates a zip file using the built in PHP ZipArchive class
 */
class DUP_PRO_Zip extends DUP_PRO_Archive
{
	/**
	 *  CREATE
	 *  Creates the zip file and adds the SQL file to the archive
	 */
	static public function Create(DUP_PRO_Archive $archive, $build_progress)
	{
		$timed_out = false;

		try
		{
			$archive->Package->safe_tmp_cleanup(true);

			$countFiles = 0;
			$countDirs = 0;

			/* @var $global DUP_PRO_Global_Entity */
			$global = DUP_PRO_Global_Entity::get_instance();

			/* @var $build_progress DUP_PRO_Build_Progress */
			$timerAllStart = DUP_PRO_Util::GetMicrotime();

			$compressDir = rtrim(DUP_PRO_Util::SafePath($archive->PackDir), '/');
			$sqlPath = DUP_PRO_Util::SafePath("{$archive->Package->StorePath}/{$archive->Package->Database->File}");
			$zipPath = DUP_PRO_Util::SafePath("{$archive->Package->StorePath}/{$archive->File}");
			$zipArchive = new ZipArchive();

			$filterDirs = empty($archive->FilterDirs) ? 'not set' : $archive->FilterDirs;
			$filterExts = empty($archive->FilterExts) ? 'not set' : $archive->FilterExts;
			$filterFiles = empty($archive->FilterFiles) ? 'not set' : $archive->FilterFiles;
			$filterOn = ($archive->FilterOn) ? 'ON' : 'OFF';

			//LOAD SCAN REPORT
			$scan_filepath = DUPLICATOR_PRO_SSDIR_PATH_TMP . "/{$archive->Package->NameHash}_scan.json";

			$json = '';

			if (file_exists($scan_filepath))
			{
				$json = file_get_contents($scan_filepath);

				if (empty($json))
				{
					$error_text = DUP_PRO_U::__("Scan file $scan_filepath is empty!");
					$fix_text = DUP_PRO_U::__("Go to: Settings > Packages Tab > JSON to Custom.");

					DUP_PRO_U::log($error_text);
					DUP_PRO_Log::Error("$error_text **RECOMMENDATION:  $fix_text.", '', false);

					$system_global = DUP_PRO_System_Global_Entity::get_instance();

					$system_global->add_recommended_text_fix($error_text, $fix_text);

					$system_global->save();

					$build_progress->failed = true;
					return true;
				}
			}
			else
			{
				DUP_PRO_U::log("**** scan file $scan_filepath doesn't exist!!");
				$error_message = sprintf(DUP_PRO_U::__("ERROR: Can't find Scanfile %s. Please ensure there no non-English characters in the package or schedule name."), $scan_filepath);

				DUP_PRO_Log::Error($error_message, '', false);

				$build_progress->failed = true;
				return true;
			}

			$scanReport = json_decode($json);

			if ($build_progress->archive_started == false)
			{
				DUP_PRO_Log::Info("\n********************************************************************************");
				DUP_PRO_Log::Info("ARCHIVE Type=ZIP Mode=ZipArchive");
				DUP_PRO_Log::Info("********************************************************************************");
				DUP_PRO_Log::Info("ARCHIVE DIR:  " . $compressDir);
				DUP_PRO_Log::Info("ARCHIVE FILE: " . basename($zipPath));
				DUP_PRO_Log::Info("FILTERS: *{$filterOn}*");
				DUP_PRO_Log::Info("DIRS:  {$filterDirs}");
				DUP_PRO_Log::Info("EXTS:  {$filterExts}");
				DUP_PRO_Log::Info("FILES:  {$filterFiles}");

				DUP_PRO_Log::Info("----------------------------------------");
				DUP_PRO_Log::Info("COMPRESSING");
				DUP_PRO_Log::Info("SIZE:\t" . $scanReport->ARC->Size);
				DUP_PRO_Log::Info("STATS:\tDirs " . $scanReport->ARC->DirCount . " | Files " . $scanReport->ARC->FileCount . " | Total " . $scanReport->ARC->FullCount);

				if (($scanReport->ARC->DirCount == '') || ($scanReport->ARC->FileCount == '') || ($scanReport->ARC->FullCount == ''))
				{
					DUP_PRO_Log::Error('Invalid Scan Report Detected', 'Invalid Scan Report Detected', false);
					$build_progress->failed = true;
					return true;
				}

				if ($zipArchive->open($zipPath, ZipArchive::CREATE))
				{
					$isSQLInZip = $zipArchive->addFile($sqlPath, 'database.sql');

					if ($isSQLInZip)
					{
						DUP_PRO_Log::Info("SQL ADDED: " . basename($sqlPath));
					}
					else
					{
						DUP_PRO_Log::Error("Unable to add database.sql to archive.", "SQL File Path [" . self::$sqlath . "]", false);
						$build_progress->failed = true;
						return true;
					}

					$zipCloseResult = $zipArchive->close();
				}
				else
				{
					DUP_PRO_Log::Error("Couldn't open $zipPath", '', false);
					$build_progress->failed = true;
					return true;
				}

				if ($zipCloseResult)
				{
					$build_progress->archive_started = true;

					$archive->Package->Update();
				}
				else
				{
					DUP_PRO_Log::Error("ZipArchive close failure.", "This hosted server may have a disk quota limit.\nCheck to make sure this archive file can be stored.", '', false);
					$build_progress->failed = true;
					return true;
				}
			}

			//ZIP DIRECTORIES
			if ($zipArchive->open($zipPath, ZipArchive::CREATE))
			{
				foreach ($scanReport->ARC->Dirs as $dir)
				{
					if ($build_progress->next_archive_dir_index == $countDirs)
					{
						if ($zipArchive->addEmptyDir(ltrim(str_replace($compressDir, '', $dir), '/')))
						{
							$countDirs++;

							$build_progress->next_archive_dir_index = $countDirs;
							$archive->Package->update();
						}
						else
						{
							//Don't warn when dirtory is the root path
							if (strcmp($dir, rtrim($compressDir, '/')) != 0)
							{
								DUP_PRO_Log::Info("WARNING: Unable to zip directory: '{$dir}'" . rtrim($compressDir, '/'));
							}
						}
					}
					else
					{
						$countDirs++;
					}
				}

				if ($build_progress->timed_out($global->php_max_worker_time_in_sec))
				{
					$timed_out = true;
					$diff = time() - $build_progress->thread_start_time;
					DUP_PRO_U::log("Timed out after hitting thread time of $diff {$global->php_max_worker_time_in_sec} so quitting zipping early in the directory phase");
				}
			}
			else
			{
				DUP_PRO_Log::Error("Couldn't open $zipPath", '', false);
				$build_progress->failed = true;
				return true;
			}

			if ($zipArchive->close() === false)
			{
				DUP_PRO_Log::Error("ZipArchive close failure.", "This hosted server may have a disk quota limit.\nCheck to make sure this archive file can be stored.", '', false);
				$build_progress->failed = true;
				return true;
			}

			if ($timed_out == false)
			{
				if ($build_progress->retries > DUP_PRO_Constants::MAX_BUILD_RETRIES)
				{
					$error_msg = DUP_PRO_U::__('Package build appears stuck so marking package as failed. Is the Max Worker Time set too high?.');
					DUP_PRO_Log::Error(DUP_PRO_U::__('Build Failure'), $error_msg, false);
					DUP_PRO_U::log($error_msg);
					$build_progress->failed = true;
					return true;
				}
				else
				{
					$build_progress->retries++;
					$archive->Package->update();
				}

				/* ZIP FILES: Network Flush
				 *  This allows the process to not timeout on fcgi 
				 *  setups that need a response every X seconds */
				$archiving = false;

				$zip_is_open = false;

				$total_file_size = 0;
				$incremental_file_size = 0;
				$used_zip_file_descriptor_count = 0;

				$total_file_count = count($scanReport->ARC->Files);

				if ($archive->Package->ziparchive_mode == DUP_PRO_ZipArchive_Mode::SingleThread)
				{
					// Since we have to estimate progress in Single Thread mode set the status when we start archiving just like Shell Exec 
					$archive->Package->Status = DUP_PRO_PackageStatus::ARCSTART;
					$archive->Package->Update();
				}

				foreach ($scanReport->ARC->Files as $file)
				{
					if ($archiving || ($countFiles == $build_progress->next_archive_file_index))
					{
						if (!$archiving)
						{
							DUP_PRO_U::log("resuming archive building at file # $countFiles");
						}

						$archiving = true;

						if ($zip_is_open === false)
						{
							if ($zipArchive->open($zipPath, ZipArchive::CREATE) === false)
							{
								DUP_PRO_Log::Error("Couldn't open $zipPath", '', false);
								$build_progress->failed = true;
								return true;
							}
							$zip_is_open = true;
						}


						if ($global->server_load_reduction != DUP_PRO_Server_Load_Reduction::None)
						{
							$usec_delay = DUP_PRO_Server_Load_Reduction::microseconds_from_reduction($global->server_load_reduction);

							usleep($usec_delay);
						}

						$original_filename = $file;

						//	$is_utf8 = mb_detect_encoding($file, 'UTF-8', true);

						$non_ascii = preg_match('/[^\x20-\x7f]/', $file);

						if ($non_ascii)
						{
							DUP_PRO_U::log("$file is non ASCII");

							if(DUP_PRO_U::is_utf8($file))
							{
								// Necessary for adfron type files
								$file = utf8_decode($file);
							}
						
							if (file_exists($file) === false)
							{
								// Revert to the original filename
								$file = $original_filename;

								if (file_exists($file) === false)
								{
									// If still cant get it bail out
									DUP_PRO_U::log("$file CAN'T BE READ!");
									continue;
								}
							}
						}
						else
						{
							if (!file_exists($file))
							{
								DUP_PRO_U::log("ASCII $file ($original_filename) DOESNT EXIST!");
								continue;
							}
						}

						$local_name = ltrim(str_replace($compressDir, '', $file), '/');

							if ((filesize($file) < DUP_PRO_Constants::ZIP_STRING_LIMIT) && ($global->ziparchive_mode == DUP_PRO_ZipArchive_Mode::Multithreaded))
							{
								$zip_status = $zipArchive->addFromString($local_name, file_get_contents($file));
							}
							else
							{
								// Large files and single threaded mode add files
								$zip_status = $zipArchive->addFile($file, $local_name);
								$used_zip_file_descriptor_count++;
							}

						if ($zip_status)
						{
							$file_size = filesize($file);
							$total_file_size += $file_size;
							$incremental_file_size += $file_size;
						}
						else
						{
							DUP_PRO_Log::Info("WARNING: Unable to zip file: {$file}");
							// Assumption is that we continue?? for some things this would be fatal others it would be ok - leave up to user
						}

						$countFiles++;

						$chunk_size_in_bytes = $global->ziparchive_chunk_size_in_mb * 1000000;

						if (($global->ziparchive_mode == DUP_PRO_ZipArchive_Mode::Multithreaded) &&
								(($incremental_file_size > $chunk_size_in_bytes) || ($used_zip_file_descriptor_count > DUP_PRO_Constants::ZIP_MAX_FILE_DESCRIPTORS)))
						{
							// Only close because of chunk size and file descriptors when in legacy mode
							DUP_PRO_U::log("closing zip because ziparchive mode = {$global->ziparchive_mode} fd count = $used_zip_file_descriptor_count or incremental file size=$incremental_file_size and chunk size = $chunk_size_in_bytes");
							$incremental_file_size = 0;
							$used_zip_file_descriptor_count = 0;

							$zipCloseResult = $zipArchive->close();

							if ($zipCloseResult)
							{
								$adjusted_percent = floor(DUP_PRO_PackageStatus::ARCSTART + ((DUP_PRO_PackageStatus::ARCDONE - DUP_PRO_PackageStatus::ARCSTART) * ($countFiles / (float) $total_file_count)));

								$build_progress->next_archive_file_index = $countFiles;

								$build_progress->retries = 0;
								$archive->Package->Status = $adjusted_percent;
								$archive->Package->update();
								$zip_is_open = false;

								DUP_PRO_U::log("closed zip");
							}
							else
							{
								DUP_PRO_Log::Error("ZipArchive close failure.", "This hosted server may have a disk quota limit.\nCheck to make sure this archive file can be stored.", '', false);
								$build_progress->failed = true;
								return true;
							}
						}
					}
					else
					{
						$countFiles++;
					}

					if (($global->ziparchive_mode == DUP_PRO_ZipArchive_Mode::Multithreaded) && ($build_progress->timed_out($global->php_max_worker_time_in_sec)))
					{
						// Only close because of timeout when in legacy mode
						$timed_out = true;
						$diff = time() - $build_progress->thread_start_time;
						DUP_PRO_U::log("Timed out after hitting thread time of $diff so quitting zipping early in the directory phase");

						break;
					}
				
					if(($global->ziparchive_mode == DUP_PRO_ZipArchive_Mode::SingleThread) & ($global->max_package_runtime_in_min > 0))								
					{
						$elapsed_sec = time() - $archive->Package->timer_start;
						$elapsed_minutes = $elapsed_sec / 60;
						
						if ($elapsed_minutes > $global->max_package_runtime_in_min)
						{
							DUP_PRO_U::log("#### Single thread run time greater than allowed so bailing out");
							return false;
						}
					}
				}

				DUP_PRO_U::log("total file size added to zip = $total_file_size");

				if ($zip_is_open)
				{
					DUP_PRO_U::log("Doing final zip close after adding $incremental_file_size");
					$zipCloseResult = $zipArchive->close();
					DUP_PRO_U::log("Final zip closed.");

					if ($zipCloseResult)
					{
						$build_progress->next_archive_file_index = $countFiles;
						$build_progress->retries = 0;
						$archive->Package->update();
					}
					else
					{
						DUP_PRO_Log::Error("ZipArchive close failure.", "This hosted server may have a disk quota limit.\nCheck to make sure this archive file can be stored.", false);

						$build_progress->failed = true;
						return true;
					}
				}
			}

			if ($timed_out == false)
			{
				$build_progress->archive_built = true;
				$build_progress->retries = 0;
				$archive->Package->update();

				DUP_PRO_Log::Info(print_r($zipArchive, true));

				//--------------------------------
				//LOG FINAL RESULTS
				($zipCloseResult) ? DUP_PRO_Log::Info("COMPRESSION RESULT: '{$zipCloseResult}'") : DUP_PRO_Log::Error("ZipArchive close failure.", "This hosted server may have a disk quota limit.\nCheck to make sure this archive file can be stored.");

				$timerAllEnd = DUP_PRO_Util::GetMicrotime();
				$timerAllSum = DUP_PRO_Util::ElapsedTime($timerAllEnd, $timerAllStart);


				$zipFileSize = @filesize($zipPath);
				DUP_PRO_Log::Info("COMPRESSED SIZE: " . DUP_PRO_Util::ByteSize($zipFileSize));
				DUP_PRO_Log::Info("ARCHIVE RUNTIME: {$timerAllSum}");
				DUP_PRO_Log::Info("MEMORY STACK: " . DUP_PRO_Server::get_php_memory());

				if ($zipArchive->open($zipPath))
				{
					$archive->file_count = $zipArchive->numFiles;
					DUP_PRO_U::log_object('final zip archive dump', $zipArchive);
					$archive->Package->update();

					$zipArchive->close();
				}
				else
				{
					DUP_PRO_Log::Error("ZipArchive open failure.", "Encountered when retrieving final archive file count.", '', false);
					$build_progress->failed = true;
					return true;
				}
			}
		}
		catch (Exception $e)
		{
			DUP_PRO_Log::Error("Runtime error in class-package-archive-zip.php constructor.", "Exception: {$e}");
		}

		return !$timed_out;
	}

}

?>