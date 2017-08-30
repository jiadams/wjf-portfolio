import React from 'react';

import Work from './work'; // eslint-disable-line no-unused-vars

import WorkView from './work-view'; // eslint-disable-line no-unused-vars

import TaxonomySort from './taxonomy-sort'; // eslint-disable-line no-unused-vars

import WorkPagination from './work-pagination' // eslint-disable-line no-unused-vars


'use strict';

export default class WorksBox extends React.Component {
    
    constructor() {
        super();

        this.state      = {
                            showWorks: false,
                            works: [],
                            taxonomies: [{
                                term_id: -1,
                                name: 'All',
                                slug: 'all',
                            }],
                            currentView: {
                                id: null,
                                title: null,
                                content: null,
                                previousWork: null,
                                nextWork: null,
                                show: false,

                            },
                            worksCount: null,
                            postsPerPage: 10,
                            currentPage: 1,
                            activeTaxonomy: -1,
                        };
    }

    handlePageClick(pageNumber, e) {
        e.preventDefault();
        this._setPage(pageNumber);
        return;
    }

    handleWorkClick (workId, e) {
        e.preventDefault();
        this.assignView(workId);
        return;
    }

    handleWorkNavClick (action, e ) {
        e.preventDefault();
        switch(action) {
            case 'previous':
                this.assignView( this.state.currentView.previousWork ); 
                break;
            case 'next':
                this.assignView( this.state.currentView.nextWork ); 
                break;
            case 'close':
                this._toggleView(); 
                break;
            default:
                break;
        }
        return; 
    }

    taxonomyClickHandler(activeTaxonomy, e) {
        e.preventDefault();
        if (activeTaxonomy !== this.state.activeTaxonomy) {
            this.setState( { activeTaxonomy });
            if (activeTaxonomy === -1) {
                this._fetchWorks()
            } else {
                this._fetchTaxonomy( activeTaxonomy );
            }
        }
    }

    assignView (workId) {
        let works = this.state.works;
        for( let i = 0; i < works.length; i++ ) {
            if ( workId === works[i].ID ) {
                let currentView                 = Object.assign({}, this.state.currentView);
                currentView.id                  = works[i].ID;
                currentView.title               = works[i].post_title;
                if ( i > 0 ) {
                    currentView.previousWork    = works[i - 1].ID
                } else {
                    currentView.previousWork    = null

                }
                if (i < works.length - 1 ) {
                    currentView.nextWork        = works[i + 1].ID
                } else {
                    currentView.nextWork        = null
                }
                currentView.content             = works[i].post_content;
                currentView.image               = works[i].post_image
                currentView.show                = true;
                this.setState( { currentView } );
                return;
            }
        }

    }

    componentDidMount() {
        this._initialFetch();
    }

    render() {
        const   works = this._getWorks(),
                taxonomies = this._getTaxonomies();
        return (    <div className="container works-container">
                        <div className="row">
                            <ul className="taxonomy-list">
                                { taxonomies }
                            </ul>
                        </div>
                        <div className="row">
                            <WorkView 
                                currentId                   = { this.state.currentView.id }
                                currentTitle                = { this.state.currentView.title }
                                currentPrevious             = { this.state.currentView.previousWork }
                                currentNext                 = { this.state.currentView.nextWork }
                                currentContent              = { this.state.currentView.content }
                                currentImage                = { this.state.currentView.image}
                                viewShow                    = { this.state.currentView.show } 
                                nextWorkClickHandler        = { this.handleWorkNavClick.bind(this, 'next') }
                                previousWorkClickHandler    = { this.handleWorkNavClick.bind(this, 'previous') }
                                closeWorkClickHandler       = { this.handleWorkNavClick.bind(this, 'close') } />
                        </div>
                        <div className="row">
                            <div className="grid">
                                { works }
                            </div>
                        </div>
                        <div className="row">
                            <WorkPagination 
                                worksCount                  = { this.state.worksCount }
                                postsPerPage                = { this.state.postsPerPage }
                                currentPage                 = { this.state.currentPage } 
                                handlePageClick             = { this.handlePageClick.bind(this) } />
                        </div>
                    </div> ) ;

    }

    /*Getters and Setters*/

    _getWorks() {
        return this.state.works.map(( work ) => {
            return <Work 
                id              = { work.ID }
                key             = { work.ID }
                postTitle       = { work.post_title }
                postImage       = { work.post_image } 
                handleWorkClick = { this.handleWorkClick.bind(this, work.ID) } />
            
        });
    }

    _getTaxonomies() {
        return this.state.taxonomies.map(( taxonomy ) => {
            return (    <TaxonomySort
                            termId                  = { taxonomy.term_id }
                            key                     = { taxonomy.term_id }
                            termTitle               = { taxonomy.name } 
                            activeTerm              = { this.state.activeTaxonomy } 
                            taxonomyClickHandler    = { this.taxonomyClickHandler.bind(this, taxonomy.term_id) }/>);
        })
    }

    _initialFetch() {
         jQuery.ajax({
            method: 'GET',
            url: '/wp-json/wjf-portfolio/v1/works/',
            success: ( works ) => {
                this._setWorks( works.posts );
                this._setTaxonomies( works.taxonomies );
                this._setWorksCount ( works.post_count );
            }
        });       
    }

    _fetchWorks() {
        jQuery.ajax({
            method: 'GET',
            url: '/wp-json/wjf-portfolio/v1/works/',
            success: ( works ) => {
                this._setWorks( works.posts );
                this._setWorksCount ( works.post_count );
            }
        });
    }

    _fetchWorksPage( page ) {
        jQuery.ajax({
            method: 'GET',
            url: '/wp-json/wjf-portfolio/v1/works/page/' + page,
            success: ( works ) => {
                this._setWorks( works.posts );
            }
        });
    }


    _fetchTaxonomy(termId) {
        jQuery.ajax({
            method: 'GET',
            url: '/wp-json/wjf-portfolio/v1/works/tax/' + termId,
            success: ( works ) => {
                this._setWorks( works.posts );
                this._setTaxonomiesWorkCount( this.state.taxonomies, termId );
            }
        });
    }

    _fetchTaxonomyPage( termId, pageNumber ) {
        jQuery.ajax({
            method: 'GET',
            url: '/wp-json/wjf-portfolio/v1/works/tax/' + termId + '/page/' + pageNumber,
            success: ( works ) => {
                this._setWorks( works.posts );
                this._setTaxonomiesWorkCount( this.state.taxonomies, termId );
            }
        });
    }

    /*_setCacheState( cacheName, toBeCachedData ) {

    }*/

    _setPage(pageNumber) {
        let activeTaxonomy  = this.state.activeTaxonomy;
        if ( activeTaxonomy === -1 ) {
            this._fetchWorksPage(pageNumber);
        } else {
            this._fetchTaxonomyPage(activeTaxonomy, pageNumber);
        }
        this.setState( { currentPage: pageNumber } );
    }

    _setTaxonomies ( taxonomies ) {
        this.setState( { taxonomies: this.state.taxonomies.concat( taxonomies ) } )
    }

    _setTaxonomiesWorkCount(taxonomies, termId) {
        for( let i = 1; i < taxonomies.length; i++ ){
            if( taxonomies[i].term_id == termId ) {
                return this._setWorksCount( taxonomies[i].count );
            }
        } 
    }

    _setWorks( works ) {
        this.setState( { works } );
    }

    _setWorksCount( worksCount ) {
        this.setState( { worksCount } );
    }

    _toggleView() {
        let currentView = Object.assign({}, this.state.currentView);
        currentView.show = !currentView.show;
        this.setState( { currentView } );
    }

}