import React from 'react';

import PropTypes from 'prop-types';

import WorksViewNav from './works-view-nav'

export default class ViewWork extends React.Component {

    constructor(props) {
        super(props);
        
    }

    render() {
        let workContent     = this.props.currentContent,
            workFeatImage   = this.props.currentImage,
            workTitle       = this.props.currentTitle;

        if ( this.props.viewShow ) {
            return(<div className="works-view-container active">
                        <div className="seven columns works-img-container">
                            <img  src={ workFeatImage } alt={ workTitle } title={ workTitle } />
                        </div>
                        <div className="five columns work-view-content no-gutter">
                            <WorksViewNav 
                                nextWorkClickHandler        = { this.props.nextWorkClickHandler }
                                previousWorkClickHandler    = { this.props.previousWorkClickHandler }
                                closeWorkClickHandler       = { this.props.closeWorkClickHandler }/>
                            <h2> { workTitle } </h2>
                            <div dangerouslySetInnerHTML={{ __html: workContent }}></div>
                        </div>
                    </div>
                );
        } else {
            return (<div className="works-view-container inactive"></div>);
        }
    }
}

ViewWork.propTypes = {
    viewShow:                   PropTypes.bool.isRequired,
    currentTitle:               PropTypes.string,
    currentContent:             PropTypes.string,
    currentImage:               PropTypes.string,
    nextWorkClickHandler:       PropTypes.func,
    previousWorkClickHandler:   PropTypes.func,
    closeWorkClickHandler:      PropTypes.func,
}