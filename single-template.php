<?php
if (!isset($_GET['static_template'])) {
    get_header();
}
the_content();

if (!isset($_GET['static_template'])) {
    get_footer();
}