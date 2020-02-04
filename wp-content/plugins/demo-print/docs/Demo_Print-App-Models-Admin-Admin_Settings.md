Demo_Print\App\Models\Admin\Admin_Settings
===============

Model class that implements Plugin Admin Settings




* Class name: Admin_Settings
* Namespace: Demo_Print\App\Models\Admin
* Parent class: [Demo_Print\App\Models\Admin\Base_Model](Demo_Print-App-Models-Admin-Base_Model.md)







Methods
-------


### __construct

    mixed Demo_Print\App\Models\Admin\Admin_Settings::__construct()

Constructor



* Visibility: **protected**




### register_hook_callbacks

    mixed Demo_Print\App\Models\Admin\Base_Model::register_hook_callbacks()

Register callbacks for actions and filters. Most of your add_action/add_filter
go into this method.

NOTE: register_hook_callbacks method is not called automatically. You
as a developer have to call this method where you see fit. For Example,
You may want to call this in constructor, if you feel hooks/filters
callbacks should be registered when the new instance of the class
is created.

The purpose of this method is to set the convention that first place to
find add_action/add_filter is register_hook_callbacks method.

This method is not marked abstract because it may not be needed in every
model. Making it abstract would enforce every child class to implement
the method.

If I were you, I would define register_hook_callbacks method in the child
class when it is a 'Model only' route. This is not a rule, it
is just my opinion when I would define this method.

* Visibility: **protected**
* This method is defined by [Demo_Print\App\Models\Admin\Base_Model](Demo_Print-App-Models-Admin-Base_Model.md)




### register_settings

    mixed Demo_Print\App\Models\Admin\Admin_Settings::register_settings()

Register settings



* Visibility: **public**




### sanitize

    array Demo_Print\App\Models\Admin\Admin_Settings::sanitize(array $input)

Validates submitted setting values before they get saved to the database.



* Visibility: **public**


#### Arguments
* $input **array** - &lt;p&gt;Settings Being Saved.&lt;/p&gt;



### get_plugin_settings_option_key

    string Demo_Print\App\Models\Admin\Admin_Settings::get_plugin_settings_option_key()

Returns the option key used to store the settings in database



* Visibility: **public**




### get_setting

    array Demo_Print\App\Models\Admin\Admin_Settings::get_setting(string $setting_name)

Retrieves all of the settings from the database



* Visibility: **public**


#### Arguments
* $setting_name **string** - &lt;p&gt;Setting to be retrieved.&lt;/p&gt;



### get_instance

    object Demo_Print\Core\Model::get_instance()

Provides access to a single instance of a module using the singleton pattern



* Visibility: **public**
* This method is **static**.
* This method is defined by [Demo_Print\Core\Model](Demo_Print-Core-Model.md)



