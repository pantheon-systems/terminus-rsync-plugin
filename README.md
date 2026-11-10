# Terminus Rsync Plugin

[![GitHub Actions](https://github.com/pantheon-systems/terminus-rsync-plugin/actions/workflows/ci.yml/badge.svg)](https://github.com/pantheon-systems/terminus-rsync-plugin/actions)
[![Actively Maintained](https://img.shields.io/badge/Pantheon-Actively_Maintained-yellow?logo=pantheon&color=FFDC28)](https://pantheon.io/docs/oss-support-levels#actively-maintained-support)

[![Terminus v2.x - v3.x Compatible](https://img.shields.io/badge/terminus-2.x%20--%203.x-green.svg)](https://github.com/pantheon-systems/terminus-rsync-plugin/tree/1.x)

Terminus Plugin that provides a quick shortcut for rsync-ing files to and from a [Pantheon](https://www.pantheon.io) sites.

Learn more about Terminus and Terminus Plugins at:
[https://pantheon.io/docs/terminus/plugins/](https://pantheon.io/docs/terminus/plugins/)

## Configuration

This plugin requires no configuration to use.

## Examples

Copy the `files` directory of the dev environment of the Pantheon site `my_site` into a directory named `files` in the current working directory:
```
terminus rsync my_site.dev:files .
```
Copy everything in the files directory of the dev environment of the Pantheon site `my_site` into a folder called `assets` in the current working directory, omitting the `files` directory itself:
```
terminus rsync my_site.dev:files/ ./assets
```
Copy everything in the folder `assets` in the current working directory into a folder called `assets` in the `files` directory of the dev environment of the Pantheon site `my_site`.
```
terminus rsync ./assets my_site.dev:files
```

## Limitations

Either the source or the destination must be a local file or directory; both cannot be remote.

## Installation

To install this plugin using Terminus 3:
```
terminus self:plugin:install terminus-rsync-plugin
```

On older versions of Terminus:
```
mkdir -p ~/.terminus/plugins
composer create-project --no-dev -d ~/.terminus/plugins pantheon-systems/terminus-rsync-plugin
```
For help installing, see [Manage Plugins](https://pantheon.io/docs/terminus/plugins/).

## Rollback

**When:** a release of this plugin breaks users and a fix will take more than a few hours. Otherwise fix forward with the next patch tag.

**Recover:** revert the bad change on `1.x` and tag the next patch version. Never delete or move a published tag. Users who already installed the bad version can pin the last good one with `terminus self:plugin:install pantheon-systems/terminus-rsync-plugin:<previous>`.

**Verify:** a clean scratch install (commands in [DEPLOYMENT.md](DEPLOYMENT.md#how-to-confirm-it-deployed)) shows the intended version, and Packagist lists the fixed tag first.

**Who to page:** the `developer-experience` team via `#ask-hosting`.

Full procedure: [DEPLOYMENT.md](DEPLOYMENT.md#rollback).

## Help
Use `terminus help remote:rsync` to get help on this command.
