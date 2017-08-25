import React from 'react';

import PropTypes from 'prop-types';

export default class Works extends React.Component {

    constructor(props) {
        super(props);

    }

    render() {
        let     workTitle   = this.props.postTitle,
                workImage   = this.props.postImage;
        return (
                    <div className="grid-item" >
                        <a href="#" className="work-item" onClick={this.props.handleWorkClick}>
                            <div className="works-img-container">
                                <img src={ workImage } alt={ workTitle } title={ workTitle } />
                            </div>
                            <div className="works-title-container">
                                <div className="entry-arrow"></div>
                                <h3> {workTitle } </h3>
                            </div>
                        </a>
                    </div>
        );

    }

}

Works.propTypes = {
    id:                 PropTypes.number,
    postTitle:          PropTypes.string,
    postImage:          PropTypes.string,
    handleWorkClick:    PropTypes.func,
}