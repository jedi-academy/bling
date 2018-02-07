# Create a new deployable repo
cd ~/{base}
mkdir {app}
chmod {app} 755
cd {app}
git init
git remote add origin https://github.com/{org}/{repo}.git
