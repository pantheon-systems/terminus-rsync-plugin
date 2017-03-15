## Contributing

Pull requests to this project are welcome and encouraged.

- Please ensure that all code conforms to PSR-2 conventions. `composer cbf` will fix many code style errors.
- Run the unit tests before submitting a pull request (or fix any test failures after submission).
- As new tests to cover new functionality as needed.

## Testing
The preconditions to running tests locally are:

- Run 'composer install' if your local working copy does not have a `vendor` directory yet.
- Install Terminus 1.x, and ensure it is available on your PATH as `terminus`
- Export the environment variable TERMINUS_SITE to point at a test site.
- Run `terminus auth:login`

Once that is done, use `composer test` to run the test suite. This will install the test runner, run the tests, and check the sources for PSR-2 compliance.

## Adding tests

This project uses BATS, a shell-script testing framework, to manage functional tests for this project. BATS allows you to write tests with simple shell scripts. See the [documentation on writing BATS tests](https://github.com/sstephenson/bats#writing-tests) for more information.

## Seting up testing for your own Terminus plugin

If you'd like to copy the test scripts here for use with your own Terminus plugin, follow the steps below:

- Copy the circle.yml file. No changes should be necessary.
- Copy the `require-dev` and `scripts` section from composer.json to your own project. Again, no changes should be necessary.
- Add the contents of the .gitignore file to your .gitignore.
- Duplicate the `tests` directory, and customize the tests to suite your plugin.

You will also need to configure Circle CI to run your tests. In the Circle CI settings, set up the following environment variables:

- TERMINUS_SITE: The name of a scratch Pantheon site to run tests against.
- TERMINUS_TOKEN: A Pantheon machine token that has access to the test site.

You will also need to create an ssh key pair, and add the private key to Circle CI (leave the "Hostname" field empty), and add the public key to your account on Pantheon.
