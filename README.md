# **Movie/TV Show Database**
### *Takes 2 csv files and displays movies and their titles alongside tallies of each title's number of credited directors and actors.*

## Technologies
- Bootstrap v5.1
- PHP
- CSS3
- HTML5
- JavaScript
- Built using XAMPP and VSCode

## Features
- Handles large amounts of data
- Responsive UI fits on large and small screens
- Fast JavaScript-powered search and sort functionalities
- Error handling prevents:
  - Incorrect number of submitted files
  - Incorrect format of submitted files
- Convenient "Go back" button after submission errors

## Usage
- Specifically built for XAMPP with temp folder located at `"../../temp/"` relative to main working folder (or globally, `"xamppfiles/temp"`)
  - To use a different folder, change `"../../temp/"` in `upload.php` to the desired folder
- Files must be named `titles.csv` and `credits.csv`
- Submit both files at once on the home page
- Search for specific titles using the search bar

## Limitations
- Cannot handle re-organized good data
- Certainly will do strange things with bad data
- With two csv's at about 32,000 lines, it still takes around 6 seconds to initially load the data and display the table on a local environment. It will likely run much more slowly on a real server.
- Only searches the titles column
- Doesn't remove duplicates from `titles.csv`
