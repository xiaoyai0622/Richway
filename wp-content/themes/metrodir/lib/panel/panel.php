<?php if(!defined('IS_metrodir_PANEL')) die();?>
<div class="wrap">
<h1>metrodir <?php _e('Options', 'metrodir'); ?> V.1</h1>
<?php if($settings['update']['needUpdate']) : ?>
<div class="panel" style="margin:0; padding:0; margin-right:0;">
	<div class="message warning"><span><b><?php _e('Update', 'metrodir'); ?> v<?php echo $settings['update']['currentVersion'] ?> : </b><?php _e('There is a new version available.', 'metrodir'); ?><a href="#" id="installUpdate"><?php _e('Update', 'metrodir'); ?></a></span></div>
</div>

<div id="instructions">
		<?php echo $settings['update']['instructions']; ?>
		<ul class="update-console"></ul>
		<button type="button" id="uploadZip" style="" class="red"><span>Download ZIP update FILES</span></button>
		<a href="#" class="ajax-loader update-load"></a>
		<div class="clear"></div>
</div>
<?php endif; ?>

<div class="metrodir-tabs">
	<div id="navbar">
		<ul>
			<li><a href="#profile" title="<?php _e('metrodir', 'metrodir'); ?>"><?php _e('metrodir', 'metrodir'); ?></a></li>
			<li><a href="#resume" title="<?php _e('Packages', 'metrodir'); ?>"><?php _e('Packages', 'metrodir'); ?></a></li>
			<li><a href="#config" title="<?php _e('Configuration', 'metrodir'); ?>"><?php _e('Configuration', 'metrodir'); ?></a></li>
		</ul>
	</div>

	<form action="" id="settingsForm">
	<div class="row save">
		<button type="submit" class="button-save"><span><?php _e('Save changes', 'metrodir'); ?></span></button>
		<a href="#" class="ajax-loader"></a>
	</div>
	<div class="panel" id="profile">


        <h2><?php _e('Social', 'metrodir'); ?></h2>
        <div class="content">
            <div class="row">
                <label><img src="<?php echo get_template_directory_uri(); ?>/images/facebook-icon.png" /><?php _e('Facebook', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['social']['facebook']; ?>" name="social[facebook]"/></div>
            </div>
            <div class="row">
                <label><img src="<?php echo get_template_directory_uri(); ?>/images/google-icon.png" /><?php _e('Google+', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['social']['googleplus']; ?>" name="social[googleplus]"/></div>
            </div>

            <div class="row">
                <label><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-icon.png" /><?php _e('Twitter', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['social']['twitter']; ?>" name="social[twitter]"/></div>
            </div>
            <div class="row">
                <label><img src="<?php echo get_template_directory_uri(); ?>/images/linkedin-icon.png" /><?php _e('LinkedIn', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['social']['linkedin']; ?>" name="social[linkedin]"/></div>
            </div>
            <div class="row">
                <label><img src="<?php echo get_template_directory_uri(); ?>/images/pinterest-icon.png" /><?php _e('Pinterest', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['social']['pinterest']; ?>" name="social[pinterest]"/></div>
            </div>
            <div class="row">
                <label><img src="<?php echo get_template_directory_uri(); ?>/images/dribbble-icon.png" /><?php _e('Dribbble', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['social']['dribbble']; ?>" name="social[dribbble]"/></div>
            </div>
        </div>

        <h2><?php _e('Site logo', 'metrodir'); ?></h2>
        <div class="content">
            <div class="site-logo" id="photoChange">
                <img alt="site logo" src="<?php echo get_template_directory_uri() ?>/images/logo.jpg?<?php echo md5(microtime()); ?>" />
                <span class="border"></span>
                <a href="#" class="change"><?php _e('Change', 'metrodir'); ?> [181x67]</a>
            </div>


            <div class="clear"></div>

            <div class="row">
                <label><?php _e('Footer text', 'metrodir'); ?></label>
                <div class="right"><textarea rows="" cols="" name="options[footerText]" style="height : 100px;"><?php echo $settings['options']['footerText']; ?></textarea></div>
            </div>
         </div>

        <h2><?php _e('Address Details:', 'metrodir'); ?></h2>
        <div class="content">
                                <div class="row">
                    <label><?php _e('Email', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['email']; ?>" name="metrodircompany[email]"/></div>
                </div>
                <div class="row">
                    <label><?php _e('Phone', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['phone']; ?>" name="metrodircompany[phone]"/></div>
                </div>
                <div class="row">
                    <label><?php _e('Fax', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['fax']; ?>" name="metrodircompany[fax]"/></div>
                </div>
                <div class="row">
                    <label><?php _e('Adress', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['adress']; ?>" name="metrodircompany[adress]"/></div>
                </div>
                <div class="row">
                    <label><?php _e('Website', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['website']; ?>" name="metrodircompany[website]"/></div>
                </div>
        </div>

		<h2><?php _e('Opening Hours:', 'metrodir'); ?></h2>
		<div class="content">
			<div class="block-left w50">
				<div class="row">
					<label><?php _e('1) Day interval', 'metrodir'); ?></label>
					<div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['dayint1']; ?>" name="metrodircompany[dayint1]"/></div>


                    <label><?php _e('1) Time interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['workhrs1']; ?>" name="metrodircompany[workhrs1]"/></div>
                </div>

                <div class="row">
                    <label><?php _e('2) Day interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['dayint2']; ?>" name="metrodircompany[dayint2]"/></div>

                    <label><?php _e('2) Time interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['workhrs2']; ?>" name="metrodircompany[workhrs2]"/></div>
                </div>

                <div class="row">
                    <label><?php _e('3) Day interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['dayint3']; ?>" name="metrodircompany[dayint3]"/></div>

                    <label><?php _e('3) Time interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['workhrs3']; ?>" name="metrodircompany[workhrs3]"/></div>
                </div>
                <div class="row">
                    <label><?php _e('4) Day interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['dayint4']; ?>" name="metrodircompany[dayint4]"/></div>

                    <label><?php _e('4) Time interval', 'metrodir'); ?></label>
                    <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['workhrs4']; ?>" name="metrodircompany[workhrs4]"/></div>
                </div>


            </div>
			<div class="clear"></div>
		</div>


	</div>
	<div class="panel" id="resume">
        <h2><?php _e('Packages', 'metrodir'); ?></h2>
        <div class="content">

            <div class="row">
                <label><?php _e('Currency (USD, EUR)', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['curency']; ?>" name="metrodircompany[curency]"/></div>
            </div>

            <div class="row">
                <label><?php _e('1 package name', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['1pkgname']; ?>" name="metrodircompany[1pkgname]"/></div>
            </div>
            <div class="row">
                <label><?php _e('1 package price', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['1pkgprice']; ?>" name="metrodircompany[1pkgprice]"/></div>
            </div><br/>

            <div class="row">
                <label><?php _e('2 package name', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['2pkgname']; ?>" name="metrodircompany[2pkgname]"/></div>
            </div>
            <div class="row">
                <label><?php _e('2 package price', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['2pkgprice']; ?>" name="metrodircompany[2pkgprice]"/></div>
            </div><br/>

            <div class="row">
                <label><?php _e('3 package name', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['3pkgname']; ?>" name="metrodircompany[3pkgname]"/></div>
            </div>
            <div class="row">
                <label><?php _e('3 package price', 'metrodir'); ?></label>
                <div class="right"><input type="text" value="<?php echo $settings['metrodircompany']['3pkgprice']; ?>" name="metrodircompany[3pkgprice]"/></div>
            </div>


        <div class="clear"></div>

        </div>
	</div>
	<div class="panel" id="config">
		<h2><?php _e('Configurations', 'metrodir'); ?></h2>
		<div class="content">

			<div class="row structure" style="overflow:hidden">
				<label><?php _e('Boxed version', 'metrodir'); ?></label>
				<div class="right">
                    <input type="radio" name="options[boxed]" id="boxed-1" value="yes" <?php echo $settings['options']['boxed'] == 'yes' ? ' checked="checked"' : ''; ?> />
                    <label for="boxed-1"><?php _e('Yes', 'metrodir'); ?></label>

                    <input type="radio" name="options[boxed]" id="boxed-0" value="no" <?php echo $settings['options']['boxed'] == 'no' ? ' checked="checked"' : ''; ?> />
                    <label for="boxed-0"><?php _e('No', 'metrodir'); ?></label>
			    </div>
			</div>


            <div class="row structure" style="overflow:hidden">
                <label><?php _e('Home view', 'metrodir'); ?></label>
                <div class="right">
                    <input type="radio" name="options[structure]" id="structure-1" value="map" <?php echo $settings['options']['structure'] == 'map' ? ' checked="checked"' : ''; ?> />
                    <label for="structure-1"><?php _e('Map', 'metrodir'); ?></label>

                    <input type="radio" name="options[structure]" id="structure-2" value="strv" <?php echo $settings['options']['structure'] == 'strv' ? ' checked="checked"' : ''; ?> />
                    <label for="structure-2"><?php _e('Without map', 'metrodir'); ?></label>

                    <input type="radio" name="options[structure]" id="structure-3" value="slider" <?php echo $settings['options']['structure'] == 'slider' ? ' checked="checked"' : ''; ?> />
                    <label for="structure-3"><?php _e('Revolution slider', 'metrodir'); ?></label>
                </div>
            </div>

            <div class="row structure" style="overflow:hidden">
                <label><?php _e('Centre home map', 'metrodir'); ?></label>

                <div class="right" style="display: none">
                    <input type="radio" name="options[centermap]" id="centermap-1" value="centre_addr" <?php echo $settings['options']['centermap'] == 'centre_addr' ? ' checked="checked"' : ''; ?> />

                    <label for="centermap-1"><?php _e('Centre by address:', 'metrodir'); ?></label>
                    <input type="text" value="<?php echo $settings['options']['addrcenter']; ?>" name="options[addrcenter]" width="10"/>
                </div>
<br/>
                <div class="right">
                    <input type="radio" name="options[centermap]" id="centermap-2" value="centre_geomap" <?php echo $settings['options']['centermap'] == 'centre_geomap' ? ' checked="checked"' : ''; ?> />
                    <label for="centermap-2"><?php _e('Centre by geolacation', 'metrodir'); ?></label>
                </div>
                <div class="right">
                    <input type="radio" name="options[centermap]" id="centermap-3" value="centre_random" <?php echo $settings['options']['centermap'] == 'centre_random' ? ' checked="checked"' : ''; ?> />
                    <label for="centermap-3"><?php _e('Centre by random company', 'metrodir'); ?></label>
                </div>
                <div class="right">
                    <input type="radio" name="options[centermap]" id="centermap-4" value="centre_last" <?php echo $settings['options']['centermap'] == 'centre_last' ? ' checked="checked"' : ''; ?> />
                    <label for="centermap-4"><?php _e('Centre by last company ', 'metrodir'); ?></label>
                </div>

            </div>


			<div class="row">
				<label><?php _e('Favicon', 'metrodir'); ?></label>
				<div class="right">
					<img alt="favicon" id="faviconImg" style="float:left; margin:5px;" src="<?php echo get_template_directory_uri().'/favicon.ico?'.md5(microtime()); ?>" />
					<a href="#" id="favicon" class="file-btn"></a>
				</div>
			</div>
			<div class="row" style="position:relative; display: none">
				<label><?php _e('Background Image', 'metrodir'); ?></label>
				<a href="#" class="background-new" id="backgroundNew"><?php _e('Add new background', 'metrodir'); ?></a>
				<div class="right">
					<input type="hidden" name="options[bgImg]" value="<?php echo $settings['options']['bgImg']; ?>" id="backgroundImg" />
					<ul id="backgroudImgList">

						<li<?php echo $settings['options']['bgImg'] == '' ? ' class="selected"' : ''; ?>>
							<a class="img" href="#"><img src="<?php echo get_template_directory_uri().'/images/nonebg.png';?>" alt="" /></a>
						</li>
					</ul>
					<div class="clear"></div>
				</div>
			</div>

			<div class="row">
				<label><?php _e('Copyright text', 'metrodir'); ?></label>
				<div class="right"><input type="text" value="<?php echo $settings['options']['CopyrightText']; ?>" name="options[CopyrightText]"/></div>
			</div>
				<div class="row" style="display: none">
					<label><?php _e('Check for update', 'metrodir'); ?></label>
					<button type="button" id="checkUpdate" class="green"><span><?php _e('Check', 'metrodir'); ?></span></button>
					<div class="clear"></div>
				</div>
		</div>
		<h2><?php _e('Contact Form', 'metrodir'); ?></h2>
		<div class="content">
			<div class="row">
				<label><?php _e('Contact mail', 'metrodir'); ?></label>
				<div class="right"><input type="text" value="<?php echo $settings['contact']['email']; ?>" name="contact[email]"/></div>
			</div>
			<div class="row">
				<label><?php _e('Subject', 'metrodir'); ?></label>
				<div class="right"><input type="text" value="<?php echo $settings['contact']['subject']; ?>" name="contact[subject]"/></div>
			</div>
			<div class="row" style="display:none">
				<label><?php _e('Method', 'metrodir'); ?></label>
				<div class="right">
					
					<input type="radio" name="contact[method]" id="mthd-1" value="mail"<?php echo $settings['contact']['method'] == 'mail' ? ' checked="checked"' : ''; ?> /> 
					<label style="line-height: normal;" for="mthd-1"><?php _e('Mail', 'metrodir'); ?></label>
					
					<input type="radio" name="contact[method]" id="mthd-2" value="smtp"<?php echo $settings['contact']['method'] == 'smtp' ? ' checked="checked"' : ''; ?> /> 
					<label style="line-height: normal;" for="mthd-2"><?php _e('SMTP', 'metrodir'); ?></label>
				</div>
			</div>
			<div id="smtpPanel"<?php echo $settings['contact']['method'] != 'smtp' ? ' style="display:none"' : ''; ?>>
				<div class="row">
					<label><?php _e('Protocol', 'metrodir'); ?></label>
					<div class="right">
						<input type="radio" name="smtp[protocol]" id="pro-1" value="tls"<?php echo $settings['smtp']['protocol'] == 'tls' ? ' checked="checked"' : ''; ?> /> 
						<label style="line-height: normal;" for="pro-1"><?php _e('TLS', 'metrodir'); ?></label>
						
						<input type="radio" name="smtp[protocol]" id="pro-2" value="ssl"<?php echo $settings['smtp']['protocol'] == 'ssl' ? ' checked="checked"' : ''; ?> /> 
						<label style="line-height: normal;" for="pro-2"><?php _e('SSL', 'metrodir'); ?></label>
					</div>
					<a class="guideline tooltip" title="<?php _e('SMTP connections security protocol.<br /> Gmail use \'SSL\''); ?>" href="#"></a>
				</div>
				<div class="row">
					<label><?php _e('Host', 'metrodir'); ?></label>
					<div class="right"><input type="text" value="<?php echo $settings['smtp']['host']; ?>" name="smtp[host]"/></div>
					<a class="guideline tooltip" title="<?php _e('SMTP connection host.<br /> Gmail : \'smtp.gmail.com\''); ?>" href="#"></a>
				</div>
				<div class="row">
					<label><?php _e('Port', 'metrodir'); ?></label>
					<div class="right"><input type="text" value="<?php echo $settings['smtp']['port']; ?>" name="smtp[port]"/></div>
					<a class="guideline tooltip" title="<?php _e('SMTP connection port, 25 by default.<br /> Gmail : \'465\''); ?>" href="#"></a>
				</div>
				<div class="row">
					<label><?php _e('Username', 'metrodir'); ?></label>
					<div class="right"><input type="text" value="<?php echo $settings['smtp']['username']; ?>" name="smtp[username]"/></div>
					<a class="guideline tooltip" title="<?php _e('SMTP server username.<br /> Gmail : \'your_mail\''); ?>" href="#"></a>
				</div>
				<div class="row">
					<label><?php _e('Password', 'metrodir'); ?></label>
					<div class="right"><input type="password" value="<?php echo $settings['smtp']['password']; ?>" name="smtp[password]"/></div>
					<a class="guideline tooltip" title="<?php _e('SMTP server password.<br /> Gmail : \'your_password\''); ?>" href="#"></a>
				</div>
				<div class="row">
					<button type="button" style="float:right" id="smptTest" class="green"><span><?php _e('Test Connection', 'metrodir'); ?></span></button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row save">
		<button type="submit" class="button-save"><span><?php _e('Save changes', 'metrodir'); ?></span></button>
		<a href="#" class="ajax-loader"></a>
	</div>
	<?php /*Nonce Verification*/ wp_nonce_field('metrodir_settings_save', 'noncename_metrodir' ); ?>
	</form>
</div>
</div>
<!---------------->
<!-- Templating -->
<!---------------->

	<!-- Section Template -->
	<div class="template" id="skillsSectionTemplate">
		<div class="row skills-section">
			<h3>
				<a href="#" class="skills-section-drag"></a>
				<input type="text" class="inline-input" name="skills-sections[${Index}][title]" value="Section Title ${Index}" />
			</h3>
			<a href="#" class="skills-item-add"><?php _e('Add', 'metrodir'); ?></a>
			<a href="#" class="skills-section-delete"><?php _e('Delete', 'metrodir'); ?></a>
			
			<ul class="skills">
			</ul>
		</div>
	</div>
	
	<!-- Skill Template -->
	<ul class="template" id="skillTemplate">
		<li>
			<input type="hidden" class="rats" name="skills-sections[${Index}][skills][${ItemIndex}][rats]" value="${Rats}" />
			<a href="#" class="drag"></a>
			<h4><input type="text" class="inline-input small" name="skills-sections[${Index}][skills][${ItemIndex}][title]" value="Item title ${ItemIndex}" /></h4>
			<div class="metrodir-vote">
				<div class="metrodir-vote-bar" style="width:0px;">
                    <a href="#" style="width:180px;"></a>
                    <a href="#" style="width:162px;"></a>
                    <a href="#" style="width:144px;"></a>
                    <a href="#" style="width:126px;"></a>
                    <a href="#" style="width:108px;"></a>
                    <a href="#" style="width:90px;"></a>
                    <a href="#" style="width:72px;"></a>
                    <a href="#" style="width:54px;"></a>
                    <a href="#" style="width:36px;"></a>
                    <a href="#" style="width:18px;"></a>
				</div>
			</div>
            <h4>Description: <input type="text" class="inline-input small bg" name="skills-sections[${Index}][skills][${ItemIndex}][description]" value="" /></h4>
			<a href="#" class="delete"></a>
		</li>
	</ul>
	
	<!-- Messages Template -->
	<div class="template" id="messageTemplate">
		<div class="message ${Type}"><span>${Message}</span></div>
	</div>
	
	<!-- Resume Input Template -->
	<div class="template" id="resumeInputTemplate">
		<div class="row resume-input">
			<div class="right">
				<input type="text" class="resume-item-title" name="email" placeholder="<?php _e('Title', 'metrodir'); ?>"  value="${Title}"/>
				<input type="text" class="resume-item-place" name="name" placeholder="<?php _e('Where ?', 'metrodir'); ?>" value="${Place}" />
				<input type="text" class="resume-item-date" name="name" placeholder="<?php _e('When ?', 'metrodir'); ?>" value="${Date}" />
				<textarea class="grow resume-item-desc" placeholder="<?php _e('Description', 'metrodir'); ?>">${Desc}</textarea>
				<button type="button" class="resume-item-cancel red"><span><?php _e('Cancel', 'metrodir'); ?></span></button>
				<button type="button" class="resume-item-edit"><span>${Action}</span></button>
			</div>
		</div>
	</div>
	
	<!-- Resume Item Template -->
	<ul class="template" id="resumeItemTemplate">
		<li>
			<a href="#" class="resume-item-drag"></a>
			<h4>${Title}</h4><span class="timelineDate">${Date}</span>
			<h5>${Place}</h5>
			<a href="#" class="resume-item-delete"><?php _e('Delete', 'metrodir'); ?></a><a href="#" class="resume-item-update"><?php _e('Update', 'metrodir'); ?></a>
			<p>${Desc}</p>
			<input type="hidden" name="resume[${Index}][items][${ItemIndex}][title]" value="${Title}" />
			<input type="hidden" name="resume[${Index}][items][${ItemIndex}][place]" value="${Place}" />
			<input type="hidden" name="resume[${Index}][items][${ItemIndex}][date]" value="${Date}" />
			<input type="hidden" name="resume[${Index}][items][${ItemIndex}][desc]" value="${Desc}" />
		</li>
	</ul>
	
	<!-- Resume Section Template -->
	<div class="template" id="resumeSectionTemplate">
		<div class="resume-section">  
			<h3><a href="#" class="resume-section-drag"></a><input type="text" value="Section Title ${Index}" name="resume[${Index}][title]" class="inline-input"/></h3>
			<a href="#" class="resume-item-add"><?php _e('Add', 'metrodir'); ?></a><a href="#" class="resume-section-delete"><?php _e('Delete', 'metrodir'); ?></a> <a href="#" class="resume-section-toggle"><?php _e('Expand', 'metrodir'); ?></a>
			 <ul class="resume">
			</ul>             
		</div>
	</div>

	
