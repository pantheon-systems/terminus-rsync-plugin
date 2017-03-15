#!/usr/bin/env bats

#
# confirm-install.bats
#
# Ensure that Terminus and the Composer plugin have been installed correctly
#

@test "confirm terminus version" {
  terminus --version
}

@test "get help on remote:rsync command" {
  run terminus help remote:rsync
  [[ $output == *"All of the options after --"* ]]
  [ "$status" -eq 0 ]
}
