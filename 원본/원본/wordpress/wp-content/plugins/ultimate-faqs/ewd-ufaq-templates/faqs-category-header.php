<div id='ewd-ufaq-faq-category-<?php echo esc_attr( $this->get_category_slug() ); ?>' class='ewd-ufaq-faq-category'>
	
	<div class='ewd-ufaq-faq-category-title <?php echo ( $this->get_option( 'faq-category-toggle' ) ? 'ewd-ufaq-faq-category-title-toggle' : '' ); ?>' <?php echo ( $this->get_option( 'faq-category-toggle' ) ? 'tabindex="0"' : '' ); ?> >
		
		<<?php echo esc_attr( $this->get_option( 'styling-category-heading-type' ) ); ?> title="<?php echo esc_attr( sprintf( __( 'Click here to open %s', 'ultimate-faqs' ), $this->get_category_name() ) ); ?>">
			<?php echo esc_html( $this->get_category_name() ); ?>
			<?php if ( $this->get_option( 'group-by-category-count' ) ) { ?> <span>(<?php echo esc_html( $this->get_category_count() ); ?>)</span><?php } ?>
		</<?php echo esc_attr( $this->get_option( 'styling-category-heading-type' ) ); ?>>
	
	</div>
	
	<div class='ewd-ufaq-faq-category-inner <?php echo ( $this->get_option( 'faq-category-toggle' ) ? 'ewd-ufaq-faq-category-body-hidden' : '' ); ?>' >
