import React from 'react';

import PropTypes from 'prop-types';

export default class WorkPagination extends React.Component {
    
    constructor(props) {
        super(props);
        
        this.state      = {
                            numberOfPages: 0,
        }
    }

    render() {
        let pagesNumbers    = this._getPageNumbers(),
            currentPage     = this.props.currentPage,
            numberOfPages   = this.state.numberOfPages,
            previousLink    = this._getPageNavLinks('Previous', -1),
            nextLink        = this._getPageNavLinks('Next', 1);
        if (this.state.numberOfPages > 1) {
            return (<div className="pagination-container">
                        <ul className="pagination-list">
                            {((currentPage != 1) ? previousLink : '')}
                            { pagesNumbers }
                            {((currentPage != numberOfPages) ? nextLink : '')}
                        </ul>
                    </div>);
        } else {
            return (<div className="pagination-container"></div>);
        }
    }

    componentWillReceiveProps(nextProps) {
        if( nextProps.worksCount !== this.props.worksCount || nextProps.worksPerPage !== this.props.worksPerPage) {
            this._setNumberOfPages( nextProps.worksCount, nextProps.worksPerPage );
        }
    }

    _getPageNavLinks( pageLinkText, iterator ) {
        let currentPage     = this.props.currentPage;
        let goToPage        = currentPage + iterator;
        return( <li className="pagination-list-item">
            <a href={`#${pageLinkText}`} rel="nofollow" onClick={(e) => this.props.handlePageClick( goToPage, e)}>{ pageLinkText }</a>
        </li>);
    }

    _getPageNumbers() {
        const pageNumbers = [];

        for (let i = 0; i < this.state.numberOfPages; i++ ) {
            pageNumbers.push( (i +1) );
        }

        return pageNumbers.map((pageNumber) => {
            if ( pageNumber === this.props.currentPage ) {
                return (<li key     = { pageNumber } className="pagination-list-item">
                            { pageNumber }
                        </li>);
            } else {
                return (<li key     = { pageNumber } className="pagination-list-item">
                            <a href={`#${ pageNumber }`} onClick={ (e) => this.props.handlePageClick(pageNumber, e) } rel="nofollow">{ pageNumber }</a>
                        </li>);
            }

        });
    }

    _setNumberOfPages( worksCount, worksPerPage ) {
        if( worksCount > worksPerPage ) {
            let numberOfPages   = Math.ceil(worksCount / worksPerPage );
            
            return this.setState( { numberOfPages } );
        } else {
            return this.setState( { numberOfPages: 1 } );
        }
    }

}

WorkPagination.propTypes = {
    worksCount:         PropTypes.number,
    worksPerPage:       PropTypes.number, 
    currentPage:        PropTypes.number,
    handlePageClick:    PropTypes.func,
}