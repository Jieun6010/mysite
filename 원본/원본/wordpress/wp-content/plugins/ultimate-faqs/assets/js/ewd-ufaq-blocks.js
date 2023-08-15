var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.serverSideRender,
	TextControl = wp.components.TextControl,
	SelectControl = wp.components.SelectControl,
	InspectorControls = wp.blockEditor.InspectorControls,
	Localize = wp.i18n.__;

registerBlockType( 'ultimate-faqs/ewd-ufaq-display-faq-block', {
	title: Localize( 'Display FAQs', 'ultimate-faqs' ),
	icon: 'editor-help',
	category: 'ewd-ufaq-blocks',
	attributes: {
		post_count: { 
			type: 'string',
			default: -1
		},
		group_by_category: { type: 'string' },
		faq_accordion: { type: 'string' },
		category_accordion: { type: 'string' },
		include_category: { type: 'string' },
		exclude_category: { type: 'string' },
		post__in_string: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					type: 'number',
					label: Localize( 'Number of FAQs', 'ultimate-faqs' ),
					help: Localize( 'The default of -1 means to display all FAQs.', 'ultimate-faqs' ),
					value: props.attributes.post_count,
					onChange: ( value ) => { props.setAttributes( { post_count: value } ); },
				} ),
				el( SelectControl, {
					label: Localize( 'Group FAQs by Category', 'ultimate-faqs' ),
					value: props.attributes.group_by_category,
					options: [ {value: '', label: 'Default (from settings)'}, {value: 'yes', label: 'Yes'}, {value: 'no', label: 'No'} ],
					onChange: ( value ) => { props.setAttributes( { group_by_category: value } ); },
				} ),
				el( SelectControl, {
					label: Localize( 'FAQ Accordion', 'ultimate-faqs' ),
					value: props.attributes.faq_accordion,
					options: [ {value: '', label: 'Default (from settings)'}, {value: 'yes', label: 'Yes'}, {value: 'no', label: 'No'} ],
					onChange: ( value ) => { props.setAttributes( { faq_accordion: value } ); },
				} ),
				el( SelectControl, {
					label: Localize( 'Category Accordion', 'ultimate-faqs' ),
					value: props.attributes.category_accordion,
					options: [ {value: '', label: 'Default (from settings)'}, {value: 'yes', label: 'Yes'}, {value: 'no', label: 'No'} ],
					onChange: ( value ) => { props.setAttributes( { category_accordion: value } ); },
				} ),
				el( TextControl, {
					label: Localize( 'Include Category', 'ultimate-faqs' ),
					help: Localize( 'Comma-separated list of category IDs you\'d like to include.', 'ultimate-faqs' ),
					value: props.attributes.include_category,
					onChange: ( value ) => { props.setAttributes( { include_category: value } ); },
				} ),
				el( TextControl, {
					label: Localize( 'Exclude Category', 'ultimate-faqs' ),
					help: Localize( 'Comma-separated list of category IDs you\'d like to exclude.', 'ultimate-faqs' ),
					value: props.attributes.exclude_category,
					onChange: ( value ) => { props.setAttributes( { exclude_category: value } ); },
				} ),
				el( TextControl, {
					label: Localize( 'FAQ IDs', 'ultimate-faqs' ),
					help: Localize( 'Comma-separated list of IDs, if you\'d like to display specific FAQs.', 'ultimate-faqs' ),
					value: props.attributes.post__in_string,
					onChange: ( value ) => { props.setAttributes( { post__in_string: value } ); },
				} )
			),
		);
		returnString.push( el( ServerSideRender, { 
			block: 'ultimate-faqs/ewd-ufaq-display-faq-block',
			attributes: props.attributes
		} ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'ultimate-faqs/ewd-ufaq-search-block', {
	title: Localize( 'Search FAQs', 'ultimate-faqs' ),
	icon: 'editor-help',
	category: 'ewd-ufaq-blocks',
	attributes: {
		include_category: { type: 'string' },
		exclude_category: { type: 'string' },
		show_on_load: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					label: Localize( 'Include Category', 'ultimate-faqs' ),
					value: props.attributes.include_category,
					onChange: ( value ) => { props.setAttributes( { include_category: value } ); },
				} ),
				el( TextControl, {
					label: Localize( 'Exclude Category', 'ultimate-faqs' ),
					value: props.attributes.exclude_category,
					onChange: ( value ) => { props.setAttributes( { exclude_category: value } ); },
				} ),
				el( SelectControl, {
					label: Localize( 'Show all FAQs on Page Load?', 'ultimate-faqs' ),
					value: props.attributes.show_on_load,
					options: [ {value: '', label: 'No'}, {value: 'Yes', label: 'Yes'} ],
					onChange: ( value ) => { props.setAttributes( { show_on_load: value } ); },
				} )
			),
		);
		returnString.push( el( ServerSideRender, { 
			block: 'ultimate-faqs/ewd-ufaq-search-block',
		} ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'ultimate-faqs/ewd-ufaq-submit-faq-block', {
	title: Localize( 'Submit FAQ', 'ultimate-faqs' ),
	icon: 'editor-help',
	category: 'ewd-ufaq-blocks',
	attributes: {
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push( el( ServerSideRender, { 
			block: 'ultimate-faqs/ewd-ufaq-submit-faq-block',
		} ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'ultimate-faqs/ewd-ufaq-recent-faqs-block', {
	title: Localize( 'Recent FAQs', 'ultimate-faqs' ),
	icon: 'editor-help',
	category: 'ewd-ufaq-blocks',
	attributes: {
		post_count: { 
			type: 'string',
			default: -1
		},
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					type: 'number',
					label: Localize( 'Number of FAQs', 'ultimate-faqs' ),
					value: props.attributes.post_count,
					onChange: ( value ) => { props.setAttributes( { post_count: value } ); },
				} )
			),
		);
		returnString.push( el( ServerSideRender, { 
			block: 'ultimate-faqs/ewd-ufaq-recent-faqs-block',
			attributes: props.attributes
		} ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

registerBlockType( 'ultimate-faqs/ewd-ufaq-popular-faqs-block', {
	title: Localize( 'Popular FAQs', 'ultimate-faqs' ),
	icon: 'editor-help',
	category: 'ewd-ufaq-blocks',
	attributes: {
		post_count: { 
			type: 'string',
			default: -1
		},
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					type: 'number',
					label: Localize( 'Number of FAQs', 'ultimate-faqs' ),
					value: props.attributes.post_count,
					onChange: ( value ) => { props.setAttributes( { post_count: value } ); },
				} )
			),
		);
		returnString.push( el( ServerSideRender, { 
			block: 'ultimate-faqs/ewd-ufaq-popular-faqs-block',
			attributes: props.attributes
		} ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );


