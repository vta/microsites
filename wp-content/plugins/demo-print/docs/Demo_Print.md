Demo_Print
===============

The main plugin class




* Class name: Demo_Print
* Namespace: 
* Parent class: [Demo_Print\Includes\Dependency_Loader](Demo_Print-Includes-Dependency_Loader.md)



Constants
----------


### PLUGIN_ID

    const PLUGIN_ID = 'demo-print'





### PLUGIN_NAME

    const PLUGIN_NAME = 'Demo Print'





### PLUGIN_VERSION

    const PLUGIN_VERSION = '1.0.0'





Properties
----------


### $instance

    private \Demo_Print $instance

Holds instance of this class



* Visibility: **private**
* This property is **static**.


### $plugin_path

    private string $plugin_path

Main plugin path /wp-content/plugins/<plugin-folder>/.



* Visibility: **private**
* This property is **static**.


### $plugin_url

    private string $plugin_url

Absolute plugin url <wordpress-root-folder>/wp-content/plugins/<plugin-folder>/.



* Visibility: **private**
* This property is **static**.


Methods
-------


### __construct

    mixed Demo_Print::__construct(mixed $router_class_name, mixed $routes)

Define the core functionality of the plugin.

Load the dependencies, define the locale, and bootstraps Router.

* Visibility: **public**


#### Arguments
* $router_class_name **mixed** - &lt;p&gt;Name of the Router class to load. Otherwise false.&lt;/p&gt;
* $routes **mixed** - &lt;p&gt;File that contains list of all routes. Otherwise false.&lt;/p&gt;



### get_plugin_path

    mixed Demo_Print::get_plugin_path()

Get plugin's absolute path.



* Visibility: **public**
* This method is **static**.




### get_plugin_url

    mixed Demo_Print::get_plugin_url()

Get plugin's absolute url.



* Visibility: **public**
* This method is **static**.




### set_locale

    mixed Demo_Print::set_locale()

Define the locale for this plugin for internationalization.

Uses the i18n class in order to set the domain and to register the hook
with WordPress.

* Visibility: **private**




### init_router

    void Demo_Print::init_router(mixed $router_class_name, mixed $routes)

Init Router



* Visibility: **private**


#### Arguments
* $router_class_name **mixed** - &lt;p&gt;Name of the Router class to load.&lt;/p&gt;
* $routes **mixed** - &lt;p&gt;File that contains list of all routes.&lt;/p&gt;



### get_all_controllers

    object Demo_Print::get_all_controllers()

Returns all controller objects used for current requests



* Visibility: **private**




### get_all_models

    object Demo_Print::get_all_models()

Returns all model objecs used for current requests



* Visibility: **private**




### get_settings

    array Demo_Print::get_settings()

Method that retuns all Saved Settings related to Plugin.

Only to be used by third party developers.

* Visibility: **public**
* This method is **static**.




### get_setting

    mixed Demo_Print::get_setting(string $setting_name)

Method that returns a individual setting

Only to be used by third party developers.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $setting_name **string** - &lt;p&gt;Setting to be retrieved.&lt;/p&gt;



### load_dependencies

    mixed Demo_Print\Includes\Dependency_Loader::load_dependencies(string $class)

Loads all Plugin dependencies

Converts Class parameter passed to the method into the file path & then
`require_once` that path. It works with Class as well as with Traits.

* Visibility: **public**
* This method is defined by [Demo_Print\Includes\Dependency_Loader](Demo_Print-Includes-Dependency_Loader.md)


#### Arguments
* $class **string** - &lt;p&gt;Class need to be loaded.&lt;/p&gt;



### load_registries

    void Demo_Print\Includes\Dependency_Loader::load_registries()

Load All Registry Class Files



* Visibility: **protected**
* This method is defined by [Demo_Print\Includes\Dependency_Loader](Demo_Print-Includes-Dependency_Loader.md)




### load_core

    void Demo_Print\Includes\Dependency_Loader::load_core()

Load Core MVC Classes



* Visibility: **protected**
* This method is defined by [Demo_Print\Includes\Dependency_Loader](Demo_Print-Includes-Dependency_Loader.md)




### autoload_dependencies

    mixed Demo_Print\Includes\Dependency_Loader::autoload_dependencies()

Method responsible to call all the dependencies



* Visibility: **protected**
* This method is defined by [Demo_Print\Includes\Dependency_Loader](Demo_Print-Includes-Dependency_Loader.md)



