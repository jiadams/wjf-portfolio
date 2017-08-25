import React from 'react';

import PropTypes from 'prop-types';

export default class TaxonomySort extends React.Component {

    constructor(props) {
        super(props);
        
    }

    render() {
        let termTitle       = this.props.termTitle,
            termActive      = this.props.active,
            termId          = this.props.termId;
        return(<li className="taxonomy-list-item"><a href={`#${ termId }`} onClick={this.props.taxonomyClickHandler} className={ ( termActive  ? ' active' : '' )} rel="nofollow">{ termTitle }</a></li>);
    }

}

TaxonomySort.propTypes = {
    termId:                 PropTypes.number,
    termTitle:              PropTypes.string,
    active:                 PropTypes.bool,
    taxonomyClickHandler:   PropTypes.func,
}