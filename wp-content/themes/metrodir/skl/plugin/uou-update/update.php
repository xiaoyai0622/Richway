<?php
$themetag = 'Metrodir';

function uou_update_head($themetag) {

    Global $themetag;

    if( isset( $_REQUEST['page'] ) ) {
        // Get Current Page
        $_page = esc_attr( $_REQUEST['page'] );

        if( $_page == 'siteoptions-update' ) {
            //Set Up Filesystem
            $method = get_filesystem_method();

            if( isset( $_POST['ftp_connect'] ) ) {
                $cred = unserialize( base64_decode( $_POST['ftp_connect'] ) );
                $filesystem = WP_Filesystem($cred);
            } else {
                $filesystem = WP_Filesystem();
            }

            if( $filesystem == false && $_POST['upgrade'] != 'Proceed' ) {
                $method = get_filesystem_method();
                echo "<div id='filesystem-warning' class='updated fade'><p>Failed: Filesystem preventing downloads. ( ". $method .")</p></div>";
                return;
            }

            if(isset($_REQUEST['uou_update'])){

                $_action = esc_attr( $_REQUEST['uou_update'] );

                $themename = strtolower($themetag);
                $url = 'http://www.uouapps.com/wp/update-center/'.$themename.'/lastupdate.zip';

                if( $_action == 'save' ) {
                    $temp_file_addr = download_url( esc_url( $url ) );
                    if ( is_wp_error($temp_file_addr) ) {
                        $error = esc_html( $temp_file_addr->get_error_code() );
                        if( $error == 'http_no_url' ) {
                            echo "<div class='error fade'><p>Error Update: Invalid URL. Please Update From ThemeForest Account</p></div>";
                        } else {
                            echo "<div class='error fade'><p>Error Update: Failed Upload - ".$error."</p></div>";
                        }
                        return;
                    }
                    //Unzip Downloaded ZIP
                    global $wp_filesystem;
                    $to = $wp_filesystem->wp_content_dir() . "/themes/" . get_option( 'template' ) . "/";
                    $dounzip = unzip_file($temp_file_addr, $to);

                    unlink($temp_file_addr); // Delete Temp File

                    if ( is_wp_error($dounzip) ) {
                        $error = esc_html( $dounzip->get_error_code() );
                        $data = $dounzip->get_error_data($error);

                        if($error == 'incompatible_archive') {
                            echo "<div class='error fade'><p>Error Update: Incompatible archive</p></div>";
                        }
                        if($error == 'empty_archive') {
                            echo "<div class='error fade'><p>Error Update: Empty Archive</p></div>";
                        }
                        if($error == 'mkdir_failed') {
                            echo "<div class='error fade'><p>Error Update: mkdir Failure</p></div>";
                        }
                        if($error == 'copy_failed') {
                            echo "<div class='error fade'><p>Error Update: Copy Failed</p></div>";
                        }
                        return;
                    }

                    function uou_updated_success() {
                        echo "<div class='updated fade'><p>New version installed successfully.</p></div>";
                    }
                    add_action( 'admin_notices', 'uou_updated_success' );

                }
            }
        }
    }
}
add_action( 'admin_head', 'uou_update_head' );


function uou_get_version( $url = '', $check_if_critical = false ) {

    Global $themetag;

    if( ! empty( $url ) ) {
        $fw_url = $url;
    } else {
        $themename = strtolower($themetag);
        $txt_url = 'http://www.uouapps.com/wp/update-center/'.$themename.'/chk_version.txt';
        $fw_url = $txt_url;
    }

    $output = array( 'version' => '', 'is_critical' => false );

    $version_data = get_transient( 'uou_version_data' );

    if ( $version_data != '' && $check_if_critical == false ) { return $version_data; }

    $temp_file_addr = download_url( $fw_url );
    if( ! is_wp_error( $temp_file_addr ) && $file_contents = file( $temp_file_addr ) ) {
        $index = 0;
        $index2 = 0;
        $changes = '';
        foreach ( $file_contents as $line_num => $line ) {
            $current_line = $line;

                if ( preg_match( '/^[0-9]/', $line ) ) {
                    $index++;
                    // IF Critical Update
                    if ( $check_if_critical && ( strtolower( trim( substr( $line, -10 ) ) ) == 'critical' ) ) {
                        $output['is_critical'] = true;
                    }

                    $current_line = stristr( $current_line, 'version' );
                    $current_line = preg_replace( '~[^0-9,.]~','',$current_line );
                    $output['version'][$index] = $current_line;

                } else if ($index == 1 AND $index != 2) {
                    $index2++;
                    $changes[$index2] = $line;
                }
                if ($index == 2) {
                    $output['version'][3] = $changes;
                    break;
                }

        }
        unlink( $temp_file_addr );
    } else {
        $output['version'] = get_option( 'uou_version' );
    }

    set_transient( 'uou_version_data', $output , 60*60*24 );
    return $output;
}

function uou_admin_options_update($themetag) {

    Global $themetag;

    $method = get_filesystem_method();

    $to = ABSPATH . 'wp-content/themes/' . get_option( 'template' ) . '/';

    if(isset($_POST['password'])){

        $cred = $_POST;
        $filesystem = WP_Filesystem($cred);

    }
    elseif(isset($_POST['ftp_connect'])){

        $cred = unserialize(base64_decode($_POST['ftp_connect']));
        $filesystem = WP_Filesystem($cred);

    } else {

        $filesystem = WP_Filesystem();

    };
    $url = admin_url( 'admin.php?page=siteoptions-update' );
    ?>
    <div class="wrap themes-page">
        <?php
        if($filesystem == false){

            request_filesystem_credentials ( $url );

        }  else {

            // Clear the transient to force a fresh update.
            delete_transient( 'uou_version_data' );

            $localversion = esc_html( get_option( 'uou_version' ) );
            $remoteversion = uou_get_version();

            // Test if new version
            $upd = false;
            $loc = explode( '.',$localversion);
            $rem = explode( '.',$remoteversion['version'][1]);

            if( $loc[0] < $rem[0] )
                $upd = true;
            elseif ( $loc[1] < $rem[1] )
                $upd = true;
            elseif( $loc[2] < $rem[2] )
                $upd = true;

            if ($upd AND ($localversion == $remoteversion['version'][2])) {
                $upd2 = true;
            } else {
                $upd2 = false;
            }

            ?>
            <h2><?php echo $themetag ?> WP Update</h2>
            <span style="display:none"><?php echo $method; ?></span>
            <form method="post"  enctype="multipart/form-data" id="wooform" action="">
                <?php if( $upd2 AND $upd ): ?>
                    <?php wp_nonce_field( 'update-options' ); ?>
                    <h3>A new version of <?php echo $themetag ?> WP is available.</h3>
                    <p>This updater will download and extract the latest <?php echo $themetag ?> WP files to your current theme's functions folder. </p>
                    <p>We recommend backing up your theme files and updating WordPress to latest version before proceeding.</p>
                    <p><i class="fa fa-cloud-download"></i> <strong>Available Version:</strong> <?php echo $remoteversion['version'][1]; ?></p>
                    <p><i class="fa fa-file"></i> <strong>Current Version:</strong> <?php echo $localversion; ?></p>
                    <p>Change log:<br/><?php
                        for ($i=0; $i <= count($remoteversion['version'][3]); $i++) {
                            echo $remoteversion['version'][3][$i].'<br/>';
                        }
                    ?></p>
                    <input type="submit" class="button" value="Update <?php echo $themetag ?>" />
                <?php elseif ($upd): ?>
                    <h3>You have very old version of <?php echo $themetag ?></h3>
                    <p><i class="fa fa-file"></i> <strong>Current  Version:</strong> <?php echo $localversion; ?></p>
                    <p><i class="fa fa-cloud-download"></i> <strong>Available Version:</strong> <?php echo $remoteversion['version'][1]; ?></p>
                    <p>Please Download new version from <a href="http://themeforest.net/user/uouapps/portfolio" title="ThemeForest">ThemeForest</a>.</p>
                <?php else: ?>
                    <h3>You have the latest version of <?php echo $themetag ?></h3>
                    <p><i class="fa fa-file"></i> <strong>Current Version:</strong> <?php echo $localversion; ?></p>
                <?php endif; ?>
                <input type="hidden" name="uou_update" value="save" />
                <input type="hidden" name="ftp_connect" value="<?php echo esc_attr( base64_encode(serialize($_POST))); ?>" />
            </form>

        <?php } ?>
    </div>
<?php
}