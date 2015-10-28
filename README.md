foundry
=======

A Symfony project created on October 23, 2015, 2:52 pm.

## Installation

Get your Google client-id & secret:

https://console.developers.google.com/project

Install the application:

```
composer install
php app/console doctrine:schema:create
php app/console server:run
```

Run the app: http://127.0.0.1:8000

## Collaboration

To collaborate, consider the following instructions, taking care of nicknames in URLs:
- ninsuo (a collaborator)
- chomb94 (the upstream)

1) fork this repo using the fork button above

2) checkout the forked repo locally:

```
git clone git@github.com:ninsuo/foundry.git .
```

3) add the upstream to your local repo:

```
git remote add upstream https://github.com/chomb94/foundry.git
```

Then,

- If your local repo has commits that are not in the upstream, open a pull request.

- If the upstream repo has commits that are not in your local one, run:

```
git checkout master
git fetch upstream
git merge upstream/master
```

