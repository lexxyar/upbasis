# Universal Platform basis

This package provide startup functionality to manage Universal Platform

# Installation

Install package via `composer` command

```shell
composer require lexxsoft/upbasis
```

# Initialization

To prepare Laravel project for using and developing with Universal Platform, you can run command

```shell
php artisan up:init
```

<style>
.important{
    background-color:rgb(235 68 50 / 1);
    width:80px;
    min-width:80px;
    max-width:80px;
    height:80px;
    min-height:80px;
    max-height:80px;
    margin:16px 16px 16px 0;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:2.3rem;
}
</style>

This command will install required composer packages, updates composer PSR4 section, update laravel configurations,
create resource files.
> <table cellpadding="0" style="width:100%;">
  <tr style="padding: 0">
    <!-- GitHub Stats Card -->  
    <td valign="top"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Flat_exclamation_icon.svg/80px-Flat_exclamation_icon.svg.png"</td>
    <!-- GitHub Top Language Card -->
    <td valign="top">
        This command completely overwrite:
        <ul>
        <li>/app/Http/Kernel.php</li>
        <li>app/Providers/AuthServiceProvider.php</li>
        <li>routes/web.php</li>
        <li>config/cors.php</li>
        <li>vite.config.js</li>
        <li>/resource</li>
        </ul>
        of your project.
    </td>
  </tr>
</table>
> ✅ Check
> [!note]
> :::note
> <svg class="octicon octicon-info mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13 6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"></path></svg>
> <svg class="octicon octicon-alert mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path d="M6.457 1.047c.659-1.234 2.427-1.234 3.086 0l6.082 11.378A1.75 1.75 0 0 1 14.082 15H1.918a1.75 1.75 0 0 1-1.543-2.575Zm1.763.707a.25.25 0 0 0-.44 0L1.698 13.132a.25.25 0 0 0 .22.368h12.164a.25.25 0 0 0 .22-.368Zm.53 3.996v2.5a.75.75 0 0 1-1.5 0v-2.5a.75.75 0 0 1 1.5 0ZM9 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>
<div style="display: flex; align-items: center;">
> <div class="important">!</div>
> <div style="display: flex; align-items: center;">
> <div>
> This command completely overwrite:
> <ul>
> <li>/app/Http/Kernel.php</li>
> <li>app/Providers/AuthServiceProvider.php</li>
> <li>routes/web.php</li>
> <li>config/cors.php</li>
> <li>vite.config.js</li>
> <li>/resource</li>
> </ul>
> of your project.
> </div>
> </div>
> </div>

Next packages will be installed

* laravel/sanctum
* nwidart/laravel-modules
* spatie/laravel-permission

For all packages will be called command `php artisan vendor:publish`

Run database migration to create necessary tables

```shell
php artisan migrate
```

Finally, publish configuration file

```shell
php artisan vendor:publish --provider="Lexxsoft\Upbasis\UpBasisServiceProvider" --tag="config"
```

Now your project have all required packages and resources for developing interfaces on `VueJS` and `typescript`.

# Requirements

This package use `nwidart/laravel-modules` package as main functionality to separate platform on modules.
You should install in via command

```shell
composer require nwidart/laravel-modules
```

# Force creation and overrides

## Temporary file storage

Current package add to `filesystems.disks` configuration of `tmp` disc, if it does not exist. `tmp` disc has next
configuration:

```shell
'driver' => 'local',
'root' => storage_path('tmp'),
'throw' => false,
```

This disk used for temporary created files and don't contain any important data.

## Module activators

By default `nwidart/laravel-modules` module activator is `file`. Universal Platform basis package **forcefully** create
activator with identifier `up_database` with next credentials:

```shell
'class' => \Lexxsoft\Upbasis\Support\DatabaseModuleActivator::class,
'cache-key' => 'activator.installed',
'cache-lifetime' => 5184000,
```

Next, current package set `up_database` activator as default module activator.
This provides single correct module activator for using Universal Platform.
> <div style="display: flex; align-items: center;">
> <div class="important">!</div>
> <div style="display: flex; align-items: center;">
> Provided module activator use laravel cache system
> </div>
> </div>

# Provided artisan commands

## Generate templates based on model

```shell
php artisan up:generate {module} {model} {--vers=V1}
```

This will generate next files:

* CreateRequest
* UpdateRequest
* DefaultRulesRequest
* Resource
* Controller
* Factory
* Seeder
  This generator use model `$fillable` property.

> <div style="display: flex; align-items: center;">
> <div class="important">!</div>
> <div style="display: flex; align-items: center;">
> Fill model `$fillable` property by certain fields. Otherwise, generation result will be unacceptable.
> </div>
> </div>

**Options:**

| Param/Option | Short  | Required  | Default | Description     |
|--------------|:------:|:---------:|---------|-----------------|
| module       |        |    Yes    |         | Module name     |
| model        |        |    Yes    |         | Model name      |
| --vers       |        |           | V1      | API version (*) |

(*) API version affect to package name of

* CreateRequest
* UpdateRequest
* DefaultRulesRequest
* Resource

## Install module from external repository

```shell
php artisan up:require {module} {--M|no-migration} {--T|no-translation} {--P|no-permission} {--A|no-activate} {--S|skip-server-installation} {--C|skip-client-installation} {--b|backup-exist} {--f|force}
```
Command will download and register module of Universal Platform.
> <div style="display: flex; align-items: center;">
> <div class="important">!</div>
> <div style="display: flex; align-items: center;">
> In will download file from **external** storage.
> </div>
> </div>

**Options:**

| Param/Option               | Short  | Required | Default | Description                         |
|----------------------------|:------:|:--------:|---------|-------------------------------------|
| module                     |        |   Yes    |         | Module name                         |
| --no-migration             |   -M   |          |         | Do not run migration                |
| --no-translation           |   -T   |          |         | Do not import translation           |
| --no-permission            |   -P   |          |         | Do not import permissions           |
| --no-activate              |   -A   |          |         | Do not activate module              |
| --skip-server-installation |   -S   |          |         | Skip server installation part       |
| --skip-client-installation |   -C   |          |         | Skip client installation part       |
| --backup-exist             |   -b   |          |         | Backup existed file                 |
| --force                    |   -f   |          |         | Forcefully rewrite module directory |

## Extract module
```shell
php artisan up:extract {module}
```

This will collect all module files, permissions and translations in separate `.zip` file.

**Options:**

| Param/Option               | Short  | Required | Default | Description                         |
|----------------------------|:------:|:--------:|---------|-------------------------------------|
| module                     |        |   Yes    |         | Module name                         |
