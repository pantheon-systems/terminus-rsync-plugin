## Contributing

Pull requests to this project are welcome and encouraged.

- Please ensure that all code conforms to PSR-2 conventions. `composer cbf` will fix many code style errors.
- Run the unit tests before submitting a pull request (or fix any test failures after submission).
- As new tests to cover new functionality as needed.

## Testing
The preconditions to running tests are:

- Install Terminus 1.x, and ensure it is available on your PATH as `terminus`
- Export the environment variable TERMINUS_SITE to point at a test site.
- Run `terminus auth:login`

To run the tests locally, just run `composer test`.

### Seting up testing for your own Terminus plugin

If you'd like to copy the test scripts here for use with your own Terminus plugin, you will also need to configure Circle CI to run your tests. In the Circle CI settings, set up the following environment variables:

- TERMINUS_SITE: The name of the Pantheon site to run tests against
- TERMINUS_TOKEN: A Pantheon machine token

You will also need to create an ssh key pair, and add the private key to Circle CI (leave the "Hostname" field empty), and add the public key to your account on Pantheon.

