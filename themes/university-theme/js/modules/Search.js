import $ from 'jquery';

class Search {
    constructor() {
        this.addSearchHtml();
        this.openSearch = $(".js-search-trigger");
        this.closeSearch = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsSection = $("#search-over__results");
        this.events();
        this.overlayIsOpen = false;
        this.spinnerVisible = false;
        this.previousValue;
        this.typingTimer;
    }
    events() {
        this.openSearch.on('click', this.openOverlay.bind(this));
        this.closeSearch.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.on('keyup', this.typingLogic.bind(this));
    }
    typingLogic() {
        if (this.searchField.val() !== this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.spinnerVisible) {
                    this.resultsSection.html('<div class="spinner-loader"></div>');
                    this.spinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            }
            else {
                this.resultsSection.html('');
                this.spinnerVisible = false;
            }
        }
        this.previousValue = this.searchField.val();
    }
    getResults() {
        $.getJSON(mainData.root_url + '/wp-json/university/v1/search?keyword=' + this.searchField.val(), (results) => {
            this.resultsSection.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' :'<p> No results found.</p>' }
                        ${results.generalInfo.map(result => 
                            `<li>
                                <a href="${result.permalink}">${result.title}</a> ${result.postType == 'post' ? `by ${result.authorName}` : ''}
                            </li>`
                        ).join(' ')}
                        ${results.generalInfo.length ? '</ul>' :'' }
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? '<ul class="link-list min-list">' :`<p> No results found. <a href="${mainData.root_url}/programs">View all programs</a></p>` }
                        ${results.programs.map(result => 
                            `<li>
                                <a href="${result.permalink}">${result.title}</a>
                            </li>`
                        ).join(' ')}
                        ${results.programs.length ? '</ul>' :'' }
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length ? '<ul class="professor-cards">' :`<p> No results found. </p>` }
                        ${results.professors.map(result => 
                            `
                                <li class="professor-card__list-item">
                                    <a class="professor-card" href="${result.permalink}">
                                        <img class="professor-card__image" src="${result.image}">
                                        <span class="professor-card__name">${result.title}</span>
                                    </a>
                                </li>
                            `
                        ).join(' ')}
                        ${results.professors.length ? '</ul>' :'' }
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length ? '<ul class="link-list min-list">' :`<p> No results found. <a href="${mainData.root_url}/campuses">View all campuses</a></p>` }
                        ${results.campuses.map(result => 
                            `<li>
                                <a href="${result.permalink}">${result.title}</a>
                            </li>`
                        ).join(' ')}
                        ${results.campuses.length ? '</ul>' :'' }
                        <h2 class="search-overlay__section-title">Events</h2>
                    </div>
                </div>
            `);
            this.spinnerVisible = false;
        });
    }
    keyPressDispatcher(event) {
        if (event.keyCode == 83 && !this.overlayIsOpen && !$('input, textarea').is(':focus')) { // S Key if no other field is active
            this.openOverlay();
            this.overlayIsOpen = true;
        }
        if (event.keyCode == 27 && this.overlayIsOpen) { // Esc Key
            this.closeOverlay();
            this.overlayIsOpen = false;
        }
    }
    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $("body").addClass("body-no-scroll");
        this.searchField.val('');
        setTimeout(() => this.searchField.focus(), 301);
        this.overlayIsOpen = true;
    }
    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass("body-no-scroll");
        this.overlayIsOpen = false;
    }
    addSearchHtml() {
        $("body").append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                            <input type="text" id="search-term" class="search-term" placeholder="What are you looking for?">
                            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="container">
                    <div id="search-over__results"></div>
                </div>
            </div>
        `);
    }
}
export default Search;