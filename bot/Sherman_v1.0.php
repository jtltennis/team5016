<?php
function send($text) {
	$params = array('bot_id'=>'a0476ab95a86e38cef29bd262f', 'text'=>$text);
	//$params = array('bot_id'=>'154b9df8df27c01773c1782133', 'text'=>$text);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.groupme.com/v3/bots/post");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
	echo curl_exec($ch);
	curl_error($ch);
	curl_close($ch);
	sleep(1);
}
function contains($needle, $haystack) {
    return strpos($haystack, $needle) !== false;
}

if (file_get_contents("php://input") != null) {
	$output = json_decode(file_get_contents("php://input"), true);
	if (strcmp($output['name'], "Sherman") != 0 && !contains("Luke Eidle", $output['name']) && $output['name'] != "") {
		$output['text'] = strtolower($output['text']);
		sleep(1);
		if (((strcmp($output['text'][0], '.') == 0 || strcmp($output['text'][0], 'sherman') == -6) && contains("caption", $output['text'])) || (strcmp($output['attachments'][0]['type'], "image") == 0 && rand(63, 70) == 69)) {
		//if ((strcmp($output['text'], ".caption") == 0) || count($output['attachments']) != 0) {
			$phrases = explode("\n", file_get_contents("phrases.txt"));
			send($phrases[rand(0, count($phrases)-1)]);
			//file_put_contents("logs/outputfile4.txt", "Text:\n" . print_r($output, true));
		} elseif (strcmp($output['text'][0], '.') == 0 || strcmp($output['text'][0], 'sherman') == -6) {
			if (contains("word", $output['text']) || contains('vocab', $output['text'])) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://api.urbandictionary.com/v0/random");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				//$ud = json_decode(curl_exec($ch), true);
				$ud = curl_exec($ch);
				$ud = json_decode($ud, true);
				curl_close($ch);
				//file_put_contents("logs/outputfile3.txt", "Text:\n" . print_r($ud, true));
				//send(strlen($ud[0]) . " text");
				//send($ud['list'][0]['word'] . ":\n" . $ud['list'][0]['definition'] . "\n\nExamples: " . $ud['list'][0]['example']);
				//send(print_r($ud, true));
			} elseif (contains("define ", $output['text']) || (contains('what', $output['text']) && contains('does', $output['text']) && contains('mean', $output['text']))) {
				$ch = curl_init();
				if (contains('"', $output['text'])) {
					$definition = explode('"', $output['text']);
					$definition = str_replace(' ', '%20', $definition);
					$definition = $definition[1];
				} elseif (contains("define", $output['text'])) {
					$definition = explode('define ', $output['text']);
					$definition = str_replace(' ', '%20', $definition);
					$definition = $definition[1];
				} else if (contains('what', $output['text']) && contains('does', $output['text']) && contains('mean', $output['text'])) {
					$definition = explode('what does ', $output['text']);
					$definition = explode(' mean', $definition[1]);
					$definition = str_replace(' ', '%20', $definition);
					$definition = $definition[0];
				}
				curl_setopt($ch, CURLOPT_URL, "http://api.urbandictionary.com/v0/define?term=" . $definition);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$ud = curl_exec($ch);
				$ud = json_decode($ud, true);
				curl_close($ch);
				if ($ud['list'][0]['example'] != "") {
					$inc = 0;
					while (strlen($ud['list'][$inc]['word'] . ":\n" . $ud['list'][$inc]['definition'] . "\n\nExamples: " . $ud['list'][$inc]['example']) >= 1000) {
						$inc++;
					}
					//Commented out because Luke's an asshole
					//send($ud['list'][$inc]['word'] . ":\n" . $ud['list'][$inc]['definition'] . "\n\nExamples: " . $ud['list'][$inc]['example']);
				} else {
					if ($ud['list'][0]['word'] == "" || $ud['list'][0]['definition'] == "") {
						//Commented out because Luke's an asshole
						//send("No definition found");
					} else {
						//Commented out because Luke's an asshole
						//send($ud['list'][0]['word'] . ":\n" . $ud['list'][0]['definition']);
					}
				}
			}  elseif (contains("joke", $output['text'])) {
				$jokes = explode("\n", file_get_contents("jokes.txt"));
				$joke = $jokes[rand(0, count($jokes)-1)];
				if (strlen($joke) <= 180 && contains("?", $joke)) {
					//$joke = explode( "? ", $jokes[rand(0, count($jokes)-1)]);
					$joke = explode( "? ", $joke);
					//send($joke[0] . "?");
					sleep(3);
					//send($joke[1]);
				} else {
					//send($joke);
				}
			} elseif(contains("can you", $output['text']) || contains("can anyone", $output['text'])) {
				send("I would but I'm hood");
			/*} elseif (contains("insult", $output['text'])) {
				$text = explode(' insult ', $output['text']);
				$name = ucfirst($text[2]);
				$insults = explode("\n", file_get_contents("insults.txt"));
				$insult = $insults[rand(0, count($insults)-1)];
				send($name . ":\n" . $insult);*/
			} elseif (contains("info", $output['text'])) {
				$text = explode(' ', $output['text']);
				$team = $text[2];
				if (count($text) == 3) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "?X-TBA-App-Id=frc5016:chatbot-scout:v1");
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$data = curl_exec($ch);
					$data = json_decode($data, true);
					curl_close($ch);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/history/robots?X-TBA-App-Id=frc5016:chatbot-scout:v1");
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$data2 = curl_exec($ch);
					$data2 = json_decode($data2, true);
					curl_close($ch);
					if ($data['nickname'] != "") {
						if ($data2['2016']['name'] != "TBD" && $data2['2016']['name'] != "") {
							send($data['nickname'] . ": team " . $data['team_number'] . "\nRobot name: " . $data2['2016']['name'] . "\nLocated in " . $data['location'] . ", and started in " . $data['rookie_year'] . "\nMotto: " . $data['motto'] . "\n" . $data['website']);
						} else {
							send($data['nickname'] . ": team " . $data['team_number'] . "\nLocated in " . $data['location'] . ", and started in " . $data['rookie_year'] . "\nMotto: " . $data['motto'] . "\n" . $data['website']);
						}
					} elseif (is_numeric($team)) {
						send("Team " . $team . " does not exist");
					} else {
						send("You cannot search for teams by name yet");
					}
				} elseif (count($text) > 3 && $text[1] == "info") {
					$argument = $text[3];
					if ($argument == 'media') {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/media?X-TBA-App-Id=frc5016:chatbot-scout:v01");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if (count($data) != 0) {
							foreach($data as $key => $value) {
								if ($value['type'] == 'imgur') {
									send("http://i.imgur.com/" . $value['foreign_key'] . ".png");
								} elseif ($value['type'] == 'youtube') {
									send("http://www.youtube.com/watch?v=" . $value['foreign_key']);
								} elseif ($value['type'] == 'cdphotothread') {
									send("No media for " . $team . " found");
								}
							}
						} else {
							send("No media for " . $team . " found");
						}
					} elseif (contains('sponsor', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "?X-TBA-App-Id=frc5016:chatbot-scout:v1");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if ($data['nickname'] != "") {
							$sponsorString = $data['nickname'] . ", sponsored by: ";
							$sponsors = explode(' / ', $data['name']);
							foreach($sponsors as $key => $value) {
									$sponsorString .= $value . ", ";
							}
							$sponsorString = rtrim($sponsorString, ", ");
							send($sponsorString);
						} elseif (is_numeric($team)) {
							send("Team " . $team . " does not exist");
						} else {
							send("You cannot search for teams by name yet");
						}
					} elseif (contains('event', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/events?X-TBA-App-Id=frc5016:chatbot-scout:v1");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if ($data['404'] == "" || $data['404'] == null) {
							$sendString = "Team " . $team . " is competing at:\n";
							foreach($data as $key => $value) {
								$sendString .= "[" . str_replace('2016', '', $value['key']) . "] - " . $value['name'] . "\n";
							}
							send($sendString);
						} elseif (is_numeric($team)) {
							send("Team " . $team . " does not exist");
						} else {
							send("You cannot search for teams by name yet");
						}
					} elseif (contains('all', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "?X-TBA-App-Id=frc5016:chatbot-scout:v1");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/history/robots?X-TBA-App-Id=frc5016:chatbot-scout:v1");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data2 = curl_exec($ch);
						$data2 = json_decode($data2, true);
						curl_close($ch);
						if ($data['nickname'] != "") {
							if ($data2['2016']['name'] != "TBD" && $data2['2016']['name'] != "") {
								send($data['nickname'] . ": team " . $data['team_number'] . "\nRobot name: " . $data2['2016']['name'] . "\nLocated in " . $data['location'] . ", and started in " . $data['rookie_year'] . "\nMotto: " . $data['motto'] . "\n" . $data['website']);
							} else {
								send($data['nickname'] . ": team " . $data['team_number'] . "\nLocated in " . $data['location'] . ", and started in " . $data['rookie_year'] . "\nMotto: " . $data['motto'] . "\n" . $data['website']);
							}
						} elseif (is_numeric($team)) {
							send("Team " . $team . " does not exist");
						} else {
							send("You cannot search for teams by name yet");
						}
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "?X-TBA-App-Id=frc5016:chatbot-scout:v1");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if ($data['nickname'] != "") {
							$sponsorString = $data['nickname'] . ", sponsored by: ";
							$sponsors = explode(' / ', $data['name']);
							foreach($sponsors as $key => $value) {
									$sponsorString .= $value . ", ";
							}
							$sponsorString = rtrim($sponsorString, ", ");
							send($sponsorString);
						}
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/events?X-TBA-App-Id=frc5016:chatbot-scout:v1");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if ($data['404'] == "" || $data['404'] == null) {
							$sendString = "Team " . $team . " is competing at:\n";
							foreach($data as $key => $value) {
								$sendString .= "[" . str_replace('2016', '', $value['key']) . "] - " . $value['name'] . "\n";
							}
							send($sendString);
						}
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/media?X-TBA-App-Id=frc5016:chatbot-scout:v01");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if (count($data) != 0) {
							foreach($data as $key => $value) {
								if ($value['type'] == 'imgur') {
									send("http://i.imgur.com/" . $value['foreign_key'] . ".png");
								} elseif ($value['type'] == 'youtube') {
									send("http://www.youtube.com/watch?v=" . $value['foreign_key']);
								} elseif ($value['type'] == 'cdphotothread') {
									send("No media for " . $team . " found");
								}
							}
						} else {
							send("No media for " . $team . " found");
						}
					} else {
						send("The format is\nSherman info [team number] [optional]\nOptional extras include: media, sponsor, all");
					}
				} else {
					send("The format is\nSherman info [team number] [optional]\nOptional extras include: media, sponsor, all");
				}
			} elseif (contains("event", $output['text'])) {
				$text = explode(' ', $output['text']);
				$event = $text[2];
				if (count($text) == 3) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/event/2016" . $event . "?X-TBA-App-Id=frc5016:chatbot-scout:v1");
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$data = curl_exec($ch);
					$data = json_decode($data, true);
					curl_close($ch);
					if ($data['name'] != "") {
						send($data['name'] . "\n" . $data['website']);
					} elseif (is_numeric($event)) {
						send("Event " . $event . " does not exist");
					} else {
						send("You cannot search for events by name yet. Known event codes:\nNYC: nyny\nSBPLI/Hofstra: nyli");
					}
				} elseif (count($text) > 3 && contains("event", $text[1])) {
					$argument = $text[3];
					if (contains('team', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/event/2016" . $event . "/teams?X-TBA-App-Id=frc5016:chatbot-scout:v01");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if (count($data) != 0) {
							$teams = array();
							$sendabletext = array();
							$sendabletext[] = "Teams attending include:\n";
							foreach($data as $key => $value) {
								if (strlen($sendabletext[count($sendabletext)-1]) <= 900) {
									$sendabletext[count($sendabletext)-1] .= $value['nickname'] . ' -- ' . $value['team_number'] . "\n";
								} else {
									$sendabletext[] = $value['nickname'] . ' -- ' . $value['team_number'] . "\n";
								}
								$teams[] = $value['team_number'];
							}
							foreach($sendabletext as $key => $value) {
								send($value);
							}
						} else {
							send("Event " . $event . " does not exist");
						}
					} elseif (contains('media', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/event/2016" . $event . "/teams?X-TBA-App-Id=frc5016:chatbot-scout:v01");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if (count($data) != 0) {
							foreach($data as $key => $value) {
								$team = $value['team_number'];
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/media?X-TBA-App-Id=frc5016:chatbot-scout:v01");
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$data = curl_exec($ch);
								$data = json_decode($data, true);
								curl_close($ch);
								if (count($data) != 0) {
									foreach($data as $key => $value) {
										if ($value['type'] == 'imgur') {
											send("http://i.imgur.com/" . $value['foreign_key'] . ".png");
										} elseif ($value['type'] == 'youtube') {
											send("http://www.youtube.com/watch?v=" . $value['foreign_key']);
										}
									}
								}
							}
						} else {
							send("Event " . $event . " does not exist");
						}
					} elseif (contains('photo', $argument) || contains('pic', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/event/2016" . $event . "/teams?X-TBA-App-Id=frc5016:chatbot-scout:v01");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if (count($data) != 0) {
							foreach($data as $key => $value) {
								$team = $value['team_number'];
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/media?X-TBA-App-Id=frc5016:chatbot-scout:v01");
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$data = curl_exec($ch);
								$data = json_decode($data, true);
								curl_close($ch);
								if (count($data) != 0) {
									foreach($data as $key => $value) {
										if ($value['type'] == 'imgur') {
											send("http://i.imgur.com/" . $value['foreign_key'] . ".png");
										}
									}
								}
							}
						} else {
							send("Event " . $event . " does not exist");
						}
					} elseif (contains('video', $argument)) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/event/2016" . $event . "/teams?X-TBA-App-Id=frc5016:chatbot-scout:v01");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$data = curl_exec($ch);
						$data = json_decode($data, true);
						curl_close($ch);
						if (count($data) != 0) {
							foreach($data as $key => $value) {
								$team = $value['team_number'];
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "http://www.thebluealliance.com/api/v2/team/frc" . $team . "/2016/media?X-TBA-App-Id=frc5016:chatbot-scout:v01");
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$data = curl_exec($ch);
								$data = json_decode($data, true);
								curl_close($ch);
								if (count($data) != 0) {
									foreach($data as $key => $value) {
										if ($value['type'] == 'youtube') {
											send("http://www.youtube.com/watch?v=" . $value['foreign_key']);
										}
									}
								}
							}
						} else {
							send("Event " . $event . " does not exist");
						}
					} else {
						send("The format is\nSherman event [event code] [optional]\nOptional extras include: teams, media");
					}
				} else {
					send("The format is\nSherman event [event code] [optional]\nOptional extras include: teams, media");
				}
			}
		//} elseif (((contains("big", $output['text']) || contains("large", $output['text']) || contains("small", $output['text']) || contains("tiny", $output['text'])) && (contains("it", $output['text']) || contains("you", $output['text']) || contains("that", $output['text']) || contains("this", $output['text']))) || rand(0, 1000) == 69) {
		}	elseif (rand(0, 1000) == 69) {
			send("That's what she said");
		} elseif (rand(0, 450) == 69) {
			send("Hannnn");
		} elseif (contains("420", $output['text']) || contains("4:20", $output['text'])) {
				send("Blaze it");
		} else {
			//send("" . strcmp($output['text'][0], 'dadbot'));
			//$temp = print_r($output, true);
			//file_put_contents("logs/outputfile2.txt", "Text:\n" . $output['text'] . "\n" . $output['name'] . "\n" . $temp);
		}
	} else {
		//Do nothing
		//$test = print_r($output, true);
		//file_put_contents("logs/outputfile2.txt", "Text:\nDidn't work\n" . $test . "\n" . $output . "\n" . $output['name']);
		//$output = json_decode(file_get_contents("php://input"));
		//$output = json_decode($out);
		//$output2 = json_decode($output[0]);
	}
} else {
	echo "Access Denied\n";
}
echo "Done";
?>
