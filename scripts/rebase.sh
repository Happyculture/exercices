#!/usr/bin/env bash

if [ $1 ]; then
  if [[ "$1" == "-?" || "$1" == "-h" || "$1" == "--help" || "$1" == "help" ]]; then
    echo "Usage:"
    echo "  Run the script without parameters to just rebase all branches and deal with conflicts."
    echo "  Use the --push parameter when you are ready to push (forced update)."
    echo "  Use the --skip parameter if you are sure about your merges and you want to quickly rebase without conflict."
    echo "  You can only use one parameter at a time."
    exit
  elif [ "$1" == "--push" ]; then
    PUSH=1
  elif [ "$1" == "--skip" ]; then
    SKIP=1
  fi
fi

for BRANCH in `cat scripts/branches.txt`; do
  echo "##### $BRANCH (started)"
  if [ $OLDBRANCH ]; then
    git checkout $BRANCH
    git rebase $OLDBRANCH
    if [ $SKIP ]; then
      git checkout --theirs .
      git rebase --skip
      echo "##### $BRANCH (rebase skipped)"
    fi
    echo "##### $BRANCH (rebase ended)"
  else
    echo "##### $BRANCH (rebase ignored)"
  fi
  if [ $PUSH ]; then
    git push origin $BRANCH --force
    echo "##### $BRANCH (pushed)"
  fi
  OLDBRANCH=$BRANCH
  echo
  echo
done
