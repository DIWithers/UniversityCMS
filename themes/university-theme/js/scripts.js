// 3rd party packages from NPM
import $ from 'jquery';
import slick from 'slick-carousel';

// Our modules / classes
import MobileMenu from './modules/MobileMenu';
import HeroSlider from './modules/HeroSlider';
import GoogleMap from './modules/GoogleMap';

// Instantiate a new object using our modules/classes
var mobileMenu = new MobileMenu();
var heroSlider = new HeroSlider();
var googleMap = new GoogleMap();


///Note///
// Bundles into scripts-bundled.js
// Upon changes, this file must be rebundled via command line:
// theme-folder $ gulp watch
// OR
// theme-folder $ gulp scripts
//The required files live in the app/public folder (gulpfile.js, package.json, settings.js, webpack.config.js) - https://github.com/LearnWebCode/vagrant-lamp