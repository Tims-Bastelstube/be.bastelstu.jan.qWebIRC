<?php
namespace wcf\page;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class QWebIRCPage extends AbstractPage {
	public	$templateName = 'qwebircPage';
	public	$neededPermissions = array('user.message.canUseQWebIRC');
	public  $activeMenuItem = 'wcf.header.menu.qWebIRC';
	public	$qwebirc_url = QWEBIRC_SERVER;
	public	$chat_height = QWEBIRC_HEIGHT;
	private $replace_table = array(
		' ', ',', ';', '.', ':', '§', '$', '%', '&', '#', '/', '\\', '\'', '"', '°', '?', '(', ')', '`', '´', '*',
		'+', '~', '=', '@', '²', '³', 'µ'
	);


	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// Channels
		$channels = explode("\n", QWEBIRC_CHANNELS);
		$channelString = "";
		foreach ($channels as $channel) {
			$channelString .= ((empty($channelString)) ? ('') : (',')).trim($channel);
		}
		$this->qwebirc_url .= "/?channels=".rawurlencode($channelString);
		
		// Nick
		if (WCF::getUser()->userID != 0) {
			$prefix = '';
			// check using profile option for prefix
			if (QWEBIRC_USEOPTIONPREFIX) {
				$optionID = trim(QWEBIRC_NICKPREFIXOPTION);
				$prefix = '['.trim(WCF::getUser()->getUserOption('option'.$optionID)).']';
				if ($prefix == '[]') $prefix = '';
			}
			elseif (QWEBIRC_NICKPREFIX != "") {
				// prefix nick if prefix is given
				$prefix = QWEBIRC_NICKPREFIX;
			}
			// check using profile option for nick
			if (QWEBIRC_USEOPTIONNICK) {
				$optionID = trim(QWEBIRC_NICKOPTION);
				$nick = trim(WCF::getUser()->getUserOption('option'.$optionID));
				if ($nick == '') $nick = WCF::getUser()->username;
			}
			else $nick = WCF::getUser()->username;
			$username = $prefix.$nick;
			
			// normalize nick for IRC
			$nick = str_replace($this->replace_table, '_', $username);
			$nick = preg_replace(array('!^_!', '!_$!', '!__+!'), array('', '', '_'), $nick);
			$this->qwebirc_url .= "&nick=".rawurlencode($nick);
		}
		elseif (QWEBIRC_GUESTNICK != "") {
			$this->qwebirc_url .= "&nick=".rawurlencode(QWEBIRC_GUESTNICK);
		}
		else $this->qwebirc_url .= "&nick=".rawurlencode('qwebirc_....');
		
		// always prompt for login
		$this->qwebirc_url .= "&prompt=1";
		
		// Settings ID
		if (QWEBIRC_SETTINGSID != "") {
			$this->qwebirc_url .= "&uio=".QWEBIRC_SETTINGSID;
		}
	}

	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'qwebirc_url' => $this->qwebirc_url,
			'chat_height' => $this->chat_height
		));
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		parent::show();
	}
}
?>