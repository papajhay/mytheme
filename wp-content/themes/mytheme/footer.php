    </div>
    <footer>
        <?php
        wp_nav_menu  ([
            'theme_location' => "footer",
            'container' => false, //retirer le container du bootstrap
            'menu_class' => "navbar-nav mr-auto"
        ]);
        the_widget(YoutubeWidget::class, ['youtube' => 'tMZK8JwNFJE'], ['before_widget' => '', 'after_widget' =>''])              
        ?>
    </footer>
    <div>
      <?= get_option('agence_horaire'); ?>
    </div>
    <?php wp_footer() ?>
</body>
</html>