<?php
namespace OctoShepherd;
/**
 * This interface divides the vast github API into separate top contexts
 * roughly equivalent to the sections described at http://developer.github.com/v3/
 * The primary reason for doing this is to simplify the task of locating the correct
 * method to use.
 *
 * - Activity
 * - Gists
 * - Git Data
 * - Issues
 * - Orgs
 * - Pull Requests
 * - Repositories
 * - Users
 * - Search
 * - Markdown
 */
abstract class ApiContext
{

}