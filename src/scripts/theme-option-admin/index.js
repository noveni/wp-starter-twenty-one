/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

import {
	BaseControl,
	Button,
	ExternalLink,
	PanelBody,
	PanelRow,
	Placeholder,
	Spinner,
	ToggleControl
} from '@wordpress/components';

import {
	render,
	Component,
	Fragment
} from '@wordpress/element';

class App extends Component {
  render() {
    return (
      <Fragment>
        <PanelBody
          title={ __( 'Settings' ) }
        >
          <PanelRow>
            <ToggleControl
              label={ __( 'Track Admin Users?' ) }
              help={ 'Would you like to track views of logged-in admin accounts?.' }
              checked={ true }
              onChange={ () => {} }
            />
          </PanelRow>
        </PanelBody>
      </Fragment>
    );
  }
}

render(
	<App/>,
	document.getElementById( 'ecrannoirtwentyone-theme-settings' )
);
