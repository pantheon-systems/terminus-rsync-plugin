#!/usr/bin/env bats

#
# remote-drupal.bats
#
# Run remote drupal console commands
#

@test "rsync a file over, and rsync it back again" {
  # Make a temporary directory to work in
  tmpdir=$(mktemp -d)

  # Make a test file with unique contents
  date > $tmpdir/test-time.txt

  # Copy our test file over
  run terminus rsync $tmpdir/test-time.txt $TERMINUS_SITE.dev:files
  [ "$status" -eq 0 ]

  # Copy our test file back
  run terminus rsync $TERMINUS_SITE.dev:files/test-time.txt $tmpdir/result.txt
  [ "$status" -eq 0 ]
  [ -s $tmpdir/result.txt ]

  # Make sure that the source and result files are the same
  diff $tmpdir/test-time.txt $tmpdir/result.txt

  # Clean up our temporary directory
  rm -rf $tmpdir
}
