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
                    <a href="#previous" className="works-previous" onClick={ this.props.previousWorkClickHandler }><i className="fa fa-caret-left" aria-hidden="true"></i></a>
                    <a href="#next" className="works-next"  onClick={ this.props.nextWorkClickHandler } ><i className="fa fa-caret-right" aria-hidden="true"></i></a>
                    <a href="#close" className="works-close" onClick={ this.props.closeWorkClickHandler }><i className="fa fa-times-circle" aria-hidden="true"></i></a>
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