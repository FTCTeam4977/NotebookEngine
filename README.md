NotebookEngine
=============

We where looking for a good way to store and generate our Engineering notebook, so we created our own.

How we do it:
* Meeting file added to the repository in the form of MonthDay-Year.md and pushed to GitHub
* Hook on commit setup to trigger generator on webserver
* Webserver pulls from GitHub and runs generate.php
* Markdown files used to generate HTML pages from a Smarty template

Installing
-------

Getting this setup on your webserver is easy, edit git.sh and generator.php to use the path to your repository and run git.sh whenever there is a change to the repository.