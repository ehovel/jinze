<?php
/**
 * EBR - Easybook Reloaded for Joomla! 2.5
 * License: GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * Author: Viktor Vogel
 * Projectsite: http://joomla-extensions.kubik-rubik.de/ebr-easybook-reloaded
 *
 * @license GNU/GPL
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');
$menu_info = $this->_models['entry']->getState('parameters.menu')->toArray();
$title = explode('&', $menu_info['page_heading']);
?>
<div class="headline clearfix">
	<div class="hd">
		<div class="hd">
			<h3 class="title"><?php echo $title[0];?></h3>
			<?php echo isset($title[1]) ? '<span>'.$title[1].'</span>' : '';?>
		</div>
	</div>
	<div class="crumb"><span>您的位置：</span><a href="/" title="">首页</a>|<em><?php echo $title[0];?></em></div>
</div>
<div class="contactus">
	<?php if($this->params->get('show_page_title', 1)) : ?>
        <h2 class="componentheading"><?php echo $this->heading ?></h2>
    <?php endif; ?>
	<p>为了进一步改善我公司的各项服务，加强与客户之间的交流，我们真切的希望了解各位朋友的真实情况及对我公司服务提出宝贵的意见和建议，请将您的真实情况和想法告诉我们。以便我们改进，从而提供更优质的服务，我们会在72小时内给予回复。为确保反馈信息的及时性和有效性，请您填写正确的联系方式，谢谢您的支持和协助！</p>
   <div class="contact_form forms">
   	<p class="tips">*(带*必填)</p>
		<script type="text/javascript">
            function x()
            {
                return;
            }

            function insertprompt(insert, input, start, end, revisedMessage, currentMessage)
            {
                // Internet Explorer
                if (typeof document.selection != 'undefined')
                {
                    var range = document.selection.createRange();
                    range.text = insert;
                    var range = document.selection.createRange();
                    range.move('character', 0);
                    range.select();
                }
                // Gecko Software
                else if (typeof input.selectionStart != 'undefined')
                {
                    revisedMessage = currentMessage.substr(0, start) + insert + currentMessage.substr(end);
                    document.gbookForm.gbtext.value=revisedMessage;
                    document.gbookForm.gbtext.focus();
                    var pos;
                    pos = start + insert.length;
                    input.selectionStart = pos;
                    input.selectionEnd = pos;
                }
            }

            function insert(aTag, eTag)
            {
                var input = document.forms['gbookForm'].elements['gbtext'];
                input.focus();
                // Internet Explorer
                if(typeof document.selection != 'undefined')
                {
                    var range = document.selection.createRange();
                    var insText = range.text;
                    range.text = aTag + insText + eTag;
                    range = document.selection.createRange();
                    if (insText.length == 0)
                    {
                        range.move('character', -eTag.length);
                    }
                    else
                    {
                        range.moveStart('character', aTag.length + insText.length + eTag.length);
                    }
                    range.select();
                }
                // Gecko Software
                else if (typeof input.selectionStart != 'undefined')
                {
                    var start = input.selectionStart;
                    var end = input.selectionEnd;
                    var insText = input.value.substring(start, end);
                    input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
                    var pos;
                    if (insText.length == 0)
                    {
                        pos = start + aTag.length;
                    }
                    else
                    {
                        pos = start + aTag.length + insText.length + eTag.length;
                    }
                    input.selectionStart = pos;
                    input.selectionEnd = pos;
                }
                else
                {
                    var pos;
                    var re = new RegExp('^[0-9]{0,3}$');
                    while (!re.test(pos))
                    {
                        pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
                    }
                    if (pos > input.value.length)
                    {
                        pos = input.value.length;
                    }
                    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
                    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
                }
            }

            function insertsmilie(thesmile)
            {
                var input = document.forms['gbookForm'].elements['gbtext'];
                input.focus();
                // Internet Explorer
                if(typeof document.selection != 'undefined')
                {
                    var range = document.selection.createRange();
                    var insText = range.text;
                    range.text = " "+thesmile+" ";
                    range = document.selection.createRange();
                    range.move('character', 0);
                    range.select();
                }
                // Gecko Software
                else if (typeof input.selectionStart != 'undefined')
                {
                    var start = input.selectionStart;
                    var end = input.selectionEnd;
                    var insText = input.value.substring(start, end);
                    input.value = input.value.substr(0, start) + " "+thesmile+" " + input.value.substr(end);
                    var pos;
                    pos = start + (thesmile.length + 2);
                    input.selectionStart = pos;
                    input.selectionEnd = pos;
                }
                else
                {
                    var pos;
                    var re = new RegExp('^[0-9]{0,3}$');
                    while (!re.test(pos))
                    {
                        pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
                    }
                    if (pos > input.value.length)
                    {
                        pos = input.value.length;
                    }
                    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
                    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
                }
            }

            <?php if($this->params->get('support_bbcode', false)) : ?>

            function DoPrompt(action)
            {
                var input = document.forms['gbookForm'].elements['gbtext'];
                input.focus();

                var start = input.selectionStart;
                var end = input.selectionEnd;
                var revisedMessage;
                var currentMessage = document.gbookForm.gbtext.value;

                <?php if($this->params->get('support_link', false)) : ?>

                if (action == "url")
                {
                    var thisURL = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_HERE'); ?>", "http://");
                    var thisTitle = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_WEB_PAGE_TITLE'); ?>", "<?php echo JTEXT::_('COM_EASYBOOKRELOADED_WEB_PAGE_TITLE'); ?>");
                    if (thisURL != undefined && thisTitle != undefined)
                    {
                        if  (thisURL != "" && thisTitle != "")
                        {
                            var urlBBCode = "[URL="+thisURL+"]"+thisTitle+"[/URL]";
                            insertprompt(urlBBCode, input, start, end, revisedMessage, currentMessage);
                        }
                    }
                    return;
                }

                <?php endif; ?>
                <?php if($this->params->get('support_mail', true)) : ?>

                if (action == "email")
                {
                    var thisEmail = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_EMAIL_ADDRESS'); ?>", "");
                    if (thisEmail != undefined)
                    {
                        if  (thisEmail != "")
                        {
                            var emailBBCode = "[EMAIL]"+thisEmail+"[/EMAIL]";
                            insertprompt(emailBBCode, input, start, end, revisedMessage, currentMessage);
                        }
                    }
                    return;
                }

                <?php endif; ?>

                if (action == "code")
                {
                    var thisLanguage = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_WHICH_LANGUAGE'); ?>", "");
                    if (thisLanguage != undefined)
                    {
                        if  (thisLanguage != "")
                        {
                            var codeBBCode = "[CODE="+thisLanguage+"]\n\n[/CODE]";
                            insertprompt(codeBBCode, input, start, end, revisedMessage, currentMessage);
                        }
                    }
                    return;
                }
                if (action == "youtube")
                {
                    var thisYoutube = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_YOUTUBE_VIDEO_ID'); ?>", "");
                    if (thisYoutube != undefined)
                    {
                        if  (thisYoutube != "")
                        {
                            var codeBBCode = "[YOUTUBE]"+thisYoutube+"[/YOUTUBE]";
                            insertprompt(codeBBCode, input, start, end, revisedMessage, currentMessage);
                        }
                    }
                    return;
                }

                <?php if($this->params->get('support_pic', false)) : ?>

                if (action == "image")
                {
                    var thisImage = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_OF_THE_PICTURE_YOU_WANT_TO_SHOW'); ?>", "http://");
                    if (thisImage != undefined)
                    {
                        if  (thisImage != "")
                        {
                            var imageBBCode = "[IMG]"+thisImage+"[/IMG]";
                            insertprompt(imageBBCode, input, start, end, revisedMessage, currentMessage);
                        }
                    }
                    return;
                }
                if (action == "image_link")
                {
                    var thisImage = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_OF_THE_PICTURE_YOU_WANT_TO_SHOW'); ?>", "http://");
                    var thisURL = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_HERE'); ?>", "http://");
                    if (thisImage != undefined && thisURL != undefined)
                    {
                        if  (thisImage != "" && thisURL != "")
                        {
                            var imageBBCode = "[IMGLINK="+thisURL+"]"+thisImage+"[/IMGLINK]";
                            insertprompt(imageBBCode, input, start, end, revisedMessage, currentMessage);
                        }
                    }
                    return;
                }
                <?php endif; ?>
            }
            <?php endif; ?>
        </script>
        <form name='gbookForm' action='<?php JRoute::_('index.php'); ?>' target='_top' method='post'>
            <input type='hidden' name='option' value='com_easybookreloaded' />
            <input type='hidden' name='task' value='save' />
            <input type='hidden' name='controller' value='entry' />
            <?php if($this->user->guest == 0 AND !_EASYBOOK_CANEDIT) : ?>
                <input type='hidden' name='gbname' value='<?php echo $this->entry->gbname; ?>' />
                <input type='hidden' name='gbmail' value='<?php echo $this->entry->gbmail; ?>' />
            <?php endif; ?>
            <?php if($this->entry->id) : ?>
                <input type='hidden' name='id' value='<?php echo $this->entry->id; ?>' />
            <?php endif; ?>
            <ul class="clearfixlist" cellpadding='0' cellspacing='4' border='0' >
                <?php if($this->params->get('enable_log', true)) : ?>
	                <li class="list_item" style="display:none;">
						<label class="label" for="name"><?php echo JTEXT::_('COM_EASYBOOKRELOADED_IP_ADDRESS'); ?>:<b>*</b></label>
						<input type="text" name="gbip" id="gbip" class="input_text required" value="<?php echo $this->entry->ip; ?>" disabled='disabled'>
					</li>
                <?php endif; ?>
	                <li class="list_item" >
	                    <label class="label" for='gbname'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_NAME'); ?>:
	                    	<b>*</b>
	                    </label>
	                    <?php if($this->user->guest == 1) : ?>
	                    <input type='text' name='gbname' id='gbname' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbname; ?>' />
	                    <?php elseif($this->user->guest == 0 AND !_EASYBOOK_CANEDIT) : ?>
	                    	<?php echo $this->entry->gbname; ?>
	                    <?php elseif(_EASYBOOK_CANEDIT) : ?>
	                        <input type='text' name='gbname' id='gbname' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbname; ?>' />
	                    <?php endif; ?>
	                </li>
	            <?php if($this->params->get('show_loca', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbloca'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_LOCATION'); ?>:
                        <b>&nbsp;</b>
                        </label>
                        <input type='text' name='gbloca' id='gbloca' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbloca; ?>' />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_mail', true) OR $this->params->get('require_mail', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbmail'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_EMAIL'); ?>:
                        <?php if($this->params->get('require_mail', true)) : ?>
                        	<?php echo "<b>*</b>"; ?>
                        <?php endif; ?>
                        </label>
                        <?php if($this->user->guest == 1) : ?>
                            <input type='text' name='gbmail' id='gbmail' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbmail; ?>' />
                        <?php elseif($this->user->guest == 0 AND !_EASYBOOK_CANEDIT) : ?>
                            <?php echo $this->entry->gbmail; ?>
                        <?php elseif(_EASYBOOK_CANEDIT) : ?>
                            <input type='text' name='gbmail' id='gbmail' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbmail; ?>' />
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_home', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbpage'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_HOMEPAGE'); ?></label>
                        <input type='text' name='gbpage' id='gbpage' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbpage; ?>' />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_icq', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbicq'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_ICQ_NUMBER'); ?>:
                        	<b>*</b>
                        </label>
                        <input type='text' name='gbicq' id='gbicq' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbicq; ?>' />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_aim', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbaim'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_AIM_NICKNAME'); ?></label>
                        <input type='text' name='gbaim' id='gbaim' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbaim; ?>' />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_msn', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbmsn'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_MSN_MESSENGER'); ?></label>
                        <input type='text' name='gbmsn' id='gbmsn' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbmsn; ?>' />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_yah', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbyah'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_YAHOO_MESSENGER'); ?></label>
                        <input type='text' name='gbyah' id='gbyah' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbyah; ?>'/>
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_skype', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbskype'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_SKYPE_NICKNAME'); ?></label>
                        <input type='text' name='gbskype' id='gbskype' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbskype ?>' />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('show_rating', true)) : ?>
                    <?php echo '<script src="components/com_easybookreloaded/scripts/moostarrating.js" type="text/javascript"></script>'; ?>
                    <li class="list_item">
                        <label class="label" for='gbvote'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_WEBSITE_RATING'); ?></label>
                        <?php echo "<input type='hidden' type='radio' name='gbvote' value='0' />";

                            for($i = 1; $i <= $this->params->get('rating_max', 5); $i++)
                            {
                                if((isset($this->entry->gbvote)) AND ($i == $this->entry->gbvote))
                                {
                                    echo '<input type="radio" name="gbvote" value="'.$i.'" checked="checked">';
                                }
                                else
                                {
                                    echo '<input type="radio" name="gbvote" value="'.$i.'">';
                                }
                            }
                            echo '<span id="easybookvotetip"></span>'; ?>
                    </li>
                <?php else : ?>
                    <input type='hidden' name='gbvote' value='0' />
                <?php endif; ?>
                <?php if($this->params->get('show_title', true)) : ?>
                    <li class="list_item">
                        <label class="label" for='gbtitle'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_TITLE');?>:
                        <?php if($this->params->get('require_title', true)) : ?>
                            	<b>*</b>
                        <?php endif; ?>
                        </label>
                        <input type='text' name='gbtitle' id='gbtitle' style='width:245px;' class='input_text' value='<?php echo $this->entry->gbtitle; ?>' />
                    </li>
                <?php endif; ?>
                <li class="list_item">
                	<label class="label" for='gbtext'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_GUESTBOOK_ENTRY'); ?>:
                		<b>*</b>
                	</label>
                    <textarea name='gbtext' id='gbtext' class='textarea' rows='15' cols='50'><?php echo $this->entry->gbtext; ?></textarea>
                </li>
                <?php if($this->params->get('enable_spam', true) AND ($this->params->get('enable_spam_reg') OR $this->user->guest)) : ?>
                    <li class="list_item">
                            <label class="label" for='<?php echo $this->session->get('spamcheck_field_name', null, 'easybookreloaded'); ?>'><?php echo JText::_('COM_EASYBOOKRELOADED_SPAM'); ?>:<b>*</b></label>
                            <?php echo $this->session->get('spamcheck1', null, 'easybookreloaded').' '.$this->session->get('operator', null, 'easybookreloaded').' '.$this->session->get('spamcheck2', null, 'easybookreloaded'); ?> = <input type="text" name="<?php echo $this->session->get('spamcheck_field_name', null, 'easybookreloaded'); ?>" id="<?php echo $this->session->get('spamcheck_field_name', null, 'easybookreloaded'); ?>" size="3" value="" />
                    </li>
                <?php endif; ?>
                <?php if($this->params->get('spamcheck_question') AND ($this->params->get('spamcheck_question_question') AND $this->params->get('spamcheck_question_answer')) AND ($this->params->get('enable_spam_reg') OR $this->user->guest)) : ?>
                    <li class="list_item">
                            <label class="label" for='<?php echo $this->session->get('spamcheck_question_field_name', null, 'easybookreloaded'); ?>'><?php echo $this->params->get('spamcheck_question_question', true); ?></label>
                            <input type='text' name='<?php echo $this->session->get('spamcheck_question_field_name', null, 'easybookreloaded'); ?>' id='<?php echo $this->session->get('spamcheck_question_field_name', null, 'easybookreloaded'); ?>' style='width:245px;' class='input_text' value='' />
                    </li>
                <?php endif; ?>
            </ul>
            <div class="contact_form_btn clearfix"><button type="submit" class="btn_submit">Submit</button></div>
        </form>
	</div>
</div>