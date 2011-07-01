#!/usr/bin/env bash

#Generate a new project from your HTML5 Boilerplate repo clone
#by: Rick Waldron & Michael Cetrulo


##first run
# $ cd  suprcore/build
# $ chmod +x createproject.sh && ./createproject.sh

##usage
# $ cd  suprcore/build
# $ ./createproject.sh

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

# get a name for new project
while [[ -z $name ]]
do
    echo "To create a new suprcore project, enter a new directory name:"
    read name || exit
done
dst=$src/../$name

if [[ -d $dst ]]
then
    echo "$dst exists"
else
    #create new project
    mkdir -- "$dst" || exit 1

    #sucess message
    echo "Created Directory: $dst"

    cd -- "$src"
    cp -vr -- assets build functions root *.css *.php *.png "$dst"

    #sucess message
    echo "Created Project: $dst"
fi

