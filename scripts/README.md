# How to use the rebase script ?

## Warning

The --push option of the script should be used with extreme care as it forces the update of the branches upstream.
The --skip option of the script should be used with care too as it could loose some code. If you are not sure, prefer to fix conflicts manually on each branch.
There are NO confirmations. Think twice before running a command.

## How to create a new branch for a new exercice / part ?

1. Checkout the last branch of the branches.txt file
1. Create the new branch from this one
1. Commit stuff on that branch
1. Checkout the first branch
1. Add the new branch name at the end of branches.txt
1. $ git add scripts/branches.txt
1. $ git commit --amend
1. $ ./scripts/rebase.sh --skip
1. $ ./scripts/rebase.sh --push

## How to fix an exercice

1. Checkout the branch of the exercice / part
1. Make your changes
1. Commit your changes
1. $ ./scripts/rebase.sh
1. Fix rebase conflicts then run rebase again until there are no more conflicts. If conflicts are trivial, use --skip to ignore them.
1. $ ./scripts/rebase.sh --push
