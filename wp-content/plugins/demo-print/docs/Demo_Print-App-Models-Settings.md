Demo_Print\App\Models\Settings
===============

Implements operations related to Plugin Settings.




* Class name: Settings
* Namespace: Demo_Print\App\Models
* Parent class: [Demo_Print\Core\Model](Demo_Print-Core-Model.md)



Constants
----------


### SETTINGS_NAME

    const SETTINGS_NAME = \Demo_Print::PLUGIN_ID





Properties
----------


### $settings

    protected array $settings

Holds all Settings



* Visibility: **protected**
* This property is **static**.


Methods
-------


### get_plugin_settings_option_key

    string Demo_Print\App\Models\Settings::get_plugin_settings_option_key()

Returns the Option name/key saved in the database



* Visibility: **public**
* This method is **static**.




### get_settings

    array Demo_Print\App\Models\Settings::get_settings()

Helper method that retuns all Saved Settings related to Plugin



* Visibility: **public**
* This method is **static**.




### get_setting

    mixed Demo_Print\App\Models\Settings::get_setting(string $setting_name)

Helper method that returns a individual setting



* Visibility: **public**
* This method is **static**.


#### Arguments
* $setting_name **string** - &lt;p&gt;Setting to be retrieved.&lt;/p&gt;



### delete_settings

    void Demo_Print\App\Models\Settings::delete_settings()

Helper method to delete all settings related to plugin



* Visibility: **public**
* This method is **static**.




### delete_setting

    void Demo_Print\App\Models\Settings::delete_setting(string $setting_name)

Helper method to delete a specific setting



* Visibility: **public**
* This method is **static**.


#### Arguments
* $setting_name **string** - &lt;p&gt;Setting to be Deleted.&lt;/p&gt;



### update_settings

    void Demo_Print\App\Models\Settings::update_settings(array $new_settings)

Helper method to Update Settings



* Visibility: **public**
* This method is **static**.


#### Arguments
* $new_settings **array** - &lt;p&gt;New Setting Values to store.&lt;/p&gt;



### update_setting

    void Demo_Print\App\Models\Settings::update_setting(string $setting_name, mixed $setting_value)

Helper method Update Single Setting

Similar to update_settings, this function won't by called anywhere automatically.
This is a custom helper function to delete individual setting. You can
delete this method if you don't want this ability.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $setting_name **string** - &lt;p&gt;Setting to be Updated.&lt;/p&gt;
* $setting_value **mixed** - &lt;p&gt;New value to set for that setting.&lt;/p&gt;



### get_instance

    object Demo_Print\Core\Model::get_instance()

Provides access to a single instance of a module using the singleton pattern



* Visibility: **public**
* This method is **static**.
* This method is defined by [Demo_Print\Core\Model](Demo_Print-Core-Model.md)



