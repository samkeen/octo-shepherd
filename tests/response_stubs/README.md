# Response Stubs

These are recorded raw http responses from the github api.  In tests, we create a Mock Curl object which is
wired to return use these files as the response from an http call rather than going out over the network.

## Usage Examples

```php
<?php

function testGetProperResponse()
    {
        $req = new Requester(
            array(
                'base_url'     => 'https://api.github.com',
                // auth can be fake since we are using a mocking_curl_wrapper
                'auth_name'     => 'bob',
                'auth_password' => 'secret!'
            ),
             /*
              * This will use the file 'users.octocat.starred.response' in the response_stubs dir.
              */
            $this->get_response_mocking_curl_wrapper_for('/users/octocat/starred')
        );
        $response = $req->get('/users/:user/starred', $user='octocat');
    }
```