# LinkDir
<img src="icon.png" width="64"/><b>MobCat's Link Directory Classifieds</b><br>
[Live Demo](https://www.mobcat.zip/linkdir)
![preview](https://raw.githubusercontent.com/MobCat/LinkDir/main/preview.png)
A very simple almost code free system for hosting lists of links

# Pre-requirements
A webhost that let's you place arbitrary files on it.<br>
PHP 8.2.12 or newer<br>
SQLite 3.39.2 or newer<br>
[DB Browser for SQLite](https://sqlitebrowser.org/)<br>

# Quick Setup
1. Simply download the latest build from [here](https://github.com/MobCat/LinkDir/releases/download/mian/linkdir_20240809.zip)<br>
2. Extract it into a folder for eg. `linkdir/index.php`<br>
(Make sure the `.htaccess` is in the root of the folder, otherwise people will be able to freely download your `links.db`
3. Edit the `links.db` with DB Browser or your desired sqlite editor to setup your own link lists<br>
(A totally blank db can be found [here](links.db) if you want to start 100% fresh, however this db will crash the website, as it contains NO data.)<br>
4. Remember to download and setup your [favicons](https://onlineminitools.com/website-favicon-downloader) and category gifs and place them in the `icons` folder<br>
5. Then upload your whole linkdir folder to your webhost<br>
Any further changes you would like to make to your links can be done by simply editing the `links.db` and reuploading it to your webhost<br>
A full and in-depth setup guide can be found at [SETUP.md](SETUP.md)<br>
A full customization guide can be found at [CUSTOMIZE.md](CUSTOMIZE.md)<br>

# FAQ
<i>Why do we have to download and setup the website icons our selves?</i><br>
Security, stability, consistency and customizey.<br>
Yes, these are your friends websites, but generally it's not a good idea or best practice to just blindly live import assets from external websites<br>
(see Cross-site scripting (XSS) or supply chain attacks for more info)<br>
So we download and setup our own icons as detailed in [SETUP.md](SETUP.md) <br>
so we can change or customize them if we want, or to suit the theme of your website.<br>
And we don't have to worry about the asset going missing or changing outside of our control.
