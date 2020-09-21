<?php if (is_active_sidebar('menu-sidebar')) : ?>    
    <footer>
        <div id="sidebar">
            <ul id="footer-sidebar">
                <?php dynamic_sidebar('menu-sidebar'); ?>
            </ul>
        </div>       
    </footer> 
<?php endif; ?>