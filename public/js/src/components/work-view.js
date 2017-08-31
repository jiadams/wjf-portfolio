import React from 'react';

import PropTypes from 'prop-types';

import WorksViewNav from './works-view-nav'

export default class ViewWork extends React.Component {

    constructor(props) {
        super(props);
        this.state      = {
                        viewHight: 0,
                        }
    }

    componentWillReceiveProps(nextProps) {
        if( nextProps.viewShow ) {
            this.setState({viewHight: this.viewContainer.scrollHeight});
        } else {
            this.setState({viewHight: 0});
        }
    }

    componentDidUpdate(prevProps) {
        if ( prevProps.viewShow !== this.props.viewShow ) {
            if ( ! this.props.viewShow ) {
                this.setState({viewHight: 0});
            } else {
                this.setState({viewHight: this.viewContainer.scrollHeight});
            }
        }
    }

    render() {
        let workContent     = this.props.currentContent,
            workFeatImage   = this.props.currentImage,
            workTitle       = this.props.currentTitle,
            viewHight       = this.state.viewHight;
        return  (<div className={this.props.viewShow ? "works-view-container active" : "works-view-container"} ref={ ( ele ) => {this.viewContainer = ele}} style={{height : viewHight }}>
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
                </div>);
    }

    getViewHeight() {
        if ( this.props.viewShow ) {
            return this.viewContainer.scrollHeight
        } else {
            return 0;
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