# Version Control

All the projects use Git with a repository hosted on GitHub.

## Repo naming conventions

If the repo contains the source code of the a site its name should be the main naked domain name of that site. It should be lowercased.

- Bad: `https://www.fleetmastr.com`, `www.fleetmastr.com`, `Fleetmastr.com`
- Good: `fleetmastr.com`

Sites that are hosted on a subdomain may use that subdomain in their name

- Bad: `aecordigital.com-fleetmastr`
- Good: `fleetmastr.aecordigital.com`

If the repo concerns something else, for example a package, its name should be kebab-cased.

- Bad: `LaravelBackup`, `Spoon`
- Good: `laravel-backup`, `spoon`

## Branches

If you're going to remember one thing in this guide, remember this: **Once a project has gone live, the master branch must always be stable**. It should be safe to deploy the master branch to production at all times. All branches are assumed to be active; stale branches should get cleaned up accordingly.

### Projects in initial development

Projects that aren't live yet have at least two branches: `master` and `develop`. Avoid committing directly on the master branch, always commit through develop.

Feature branches are optional, if you'd like to create a feature branch, make sure it's branched from `develop`, not `master`.

### Live projects

Once a project goes live, the `develop` branch gets deleted. All future tickets for the project will have a sprint number associated with them. The changes for these tickets should be committed on their respective sprint branches. Once the sprint is done and changes are to be made live, the corresponding sprint branch should be deployed on the `master` branch.

When multiple sprints are being developed in parallel, do make sure to keep the later sprint branches updated with the prior sprint branches.

For example, if sprint 2.4, 2.5 and 2.6 are being developed at the same time then `sprint-2.6` should be kept up-to-date with the changes from `sprint-2.5` and `sprint-2.4` branches. Likewise, `sprint-2.5` should be kept up-to-date with changes from `sprint-2.4` branch.

### Pull requests

Merging branches via GitHub pull requests is mandatory so that it is useful when:

- You want a peer to review your changes
- You want to ensure your branch can be merged and commits can be squashed via an interface
- Future you wants a quick way to retrieve that point in history by browsing passed pull requests

### Merging and rebasing

Ideally, rebase your branch regularly to reduce the chance of merge conflicts.

- If you want to deploy a feature branch to master, use `git merge <branch> --squash`
- If your push is denied, rebase your branch first using `git rebase`

## Commits

There's not strict ruling on commits in projects in initial development, however, descriptive commit messages are recommended. After a project has gone live, descriptive commit messages are required. Always use present tense in commit messages.

- Non-descriptive: `wip`, `commit`, `a lot`, `solid`
- Descriptive: `Update deps`, `Fix vat calculation in delivery costs`

Ideally, prefer granular commits.

- Acceptable: `Cart fixes`
- Better: `Fix add to cart button`, `Fix cart count on home`

## Git Tips

### Creating granular commits with `patch`

If you've made multiple changes but want to split them into more granular commits, use `git add -p`. This will open an interactive session in which you can choose which chunks you want to stage for your commit.

### Moving commits to a new branch

First, create your new branch, then revert the current branch, and finally checkout the new branch.

Don't do this to commits that have already been pushed without double checking with your collaborators!

```bash
git branch my-branch
git reset --hard HEAD~3 # OR git reset --hard <commit>
git checkout my-branch
```

## Resources

- Most of this is based on the [GitHub Flow](https://guides.github.com/introduction/flow/)
- Merge vs. rebase on [Atlassian](https://www.atlassian.com/git/tutorials/merging-vs-rebasing/workflow-walkthrough)
- Merge vs. rebase by [@porteneuve](https://medium.com/@porteneuve/getting-solid-at-git-rebase-vs-merge-4fa1a48c53aa)
