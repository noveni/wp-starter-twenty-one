/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Component } from '@wordpress/element';
import { compose } from '@wordpress/compose';
import { PluginPostStatusInfo } from '@wordpress/edit-post';
import { select, withSelect, withDispatch } from '@wordpress/data';
import { withSpokenMessages, CheckboxControl } from '@wordpress/components';



class DisableTitle extends Component {
	constructor() {
		super( ...arguments );

		this.initialize = this.initialize.bind( this );
	}


  componentDidMount() {
		this.initialize();
	}

	componentDidUpdate() {
		this.initialize();
	}

  initialize() {
		const { postmeta } = this.props;

		const titleBlock = document.querySelector( '.editor-post-title__block' );

		if ( titleBlock ) {
			const isHidden = typeof postmeta !== 'undefined' && typeof postmeta._ecrannoirtwentyone_title_hidden !== 'undefined' ? postmeta._ecrannoirtwentyone_title_hidden : false;
			const bodyClass = isHidden ? 'ecrannoirtwentyone-title-hidden' : 'ecrannoirtwentyone-title-visible';

			//remove existing class
			if ( isHidden ) {
				document.body.classList.remove( 'ecrannoirtwentyone-title-visible' );
			} else {
				document.body.classList.remove( 'ecrannoirtwentyone-title-hidden' );
			}

			document.body.classList.add( bodyClass );
		}
	}

	render() {
		const { onToggle, postmeta, posttype } = this.props;

		if ( [ 'wp_block' ].includes( posttype ) ) {
			return false;
		}

		const isHidden = typeof postmeta !== 'undefined' && typeof postmeta._ecrannoirtwentyone_title_hidden !== 'undefined' ? postmeta._ecrannoirtwentyone_title_hidden : false;

		return (
			<PluginPostStatusInfo>
				<CheckboxControl
					className="ecrannoirtwentyone-hide-title-label"
					label={ __( 'Hide ' + posttype + ' Title', 'ecrannoirtwentyone' ) }
					checked={ isHidden }
					onChange={ onToggle }
					help={ isHidden ? __( 'Title is hidden on your website.', 'ecrannoirtwentyone' ) : null }
				/>
			</PluginPostStatusInfo>
		);
	}
}


export default compose(
	withSelect( () => {
		return {
			posttype: select( 'core/editor' ).getEditedPostAttribute( 'type' ),
			postmeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
		};
	} ),
	withDispatch( ( dispatch, ownProps ) => {
		let metavalue;
		if ( typeof ownProps.postmeta !== 'undefined' && typeof ownProps.postmeta._ecrannoirtwentyone_title_hidden !== 'undefined' ) {
			metavalue = ownProps.postmeta._ecrannoirtwentyone_title_hidden;
		}
		return {
			onToggle() {
				dispatch( 'core/editor' ).editPost( {
					meta: {
						_ecrannoirtwentyone_title_hidden: ! metavalue,
					},
				} );
			},
		};
	} ),
	withSpokenMessages,
)( DisableTitle );
