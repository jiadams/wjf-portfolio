import React from 'react';

import PropTypes from 'prop-types';

export default class WorksViewNav extends React.Component {
    constructor(props) {
        super(props);
        
    }

    render() {
        return( 
            <div className="works-view-nav-container">
                <div className="works-nav-buttons">
                    <a href="#previous" className="works-previous" onClick={ this.props.previousWorkClickHandler }><span className="dashicons dashicons-arrow-left-alt2"></span></a>
                    <a href="#next" className="works-next"  onClick={ this.props.nextWorkClickHandler } ><span className="dashicons dashicons-arrow-right-alt2"></span></a>
                    <a href="#close" className="works-close" onClick={ this.props.closeWorkClickHandler }><span className="dashicons dashicons-dismiss"></span></a>
                </div>
            </div>
            );
    }
}

WorksViewNav.propTypes = {
    nextWorkClickHandler:       PropTypes.func.isRequired,
    previousWorkClickHandler:   PropTypes.func.isRequired,
    closeWorkClickHandler:      PropTypes.func.isRequired,
}