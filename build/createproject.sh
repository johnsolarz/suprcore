#!/usr/bin/env bash

#Generate a new project from your Suprcore repo clone
#by: Rick Waldron & Michael Cetrulo


##first run
# $ cd  suprcore/build
# $ chmod +x createproject.sh && ./createproject.sh [new_project]

##usage
# $ cd  suprcore/build
# $ ./createproject.sh [new_project]

#
# If [new_project] is not specified the user we will prompted to enter it.
#
# The format of [new_project] should ideally be lowercase letters with no
# spaces as it represents the directory name that your new project will live
# in.
#
# If the new project is specified as just a name ( "foo" ) then the path
# will be a sibling to suprcore's directory.
#
# If the new project is specified with an absolute path ( "/home/user/foo" )
# that path will be used.
#

# find project root (also ensure script is ran from within repo)
src=$(git rev-parse --show-toplevel) || {
  echo "try running the script from within suprcore directories." >&2
  exit 1
}
[[ -d $src ]] || {
  echo "fatal: could not determine suprcore's root directory." >&2
  echo "try updating git." >&2
  exit 1
}

if [ $# -eq 1 ]
then
    # get a name for new project from command line arguments
    name="$1"
fi

# get a name for new project from input
while [[ -z $name ]]
do
    echo "To create a new suprcore project, enter a new directory name:"
    read name || exit
done

if [[ "$name" = /* ]]
then
    dst=$name
else
    dst=$src/../$name
fi

if [[ -d $dst ]]
then
    echo "$dst exists"
else
    #create new project
    mkdir -p -- "$dst" || exit 1

    #success message
    echo "Created Directory: $dst"

    cd -- "$src"
    cp -vr -- assets build inc *.css *.png *.php "$dst"

    #success message
    echo "Created Project: $dst"
fi

