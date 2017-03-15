# dummyPacketTracer
Just a tiny and simple web application that allows to create network topologies. For educational purposes.

Start of the project: 2017

To run dev web server locally, just download or clone this repo and make sure you have PHP >= 5.6.4 installed on your machine.
Then in `dPT_server` run: `php artisan serve`

## Functions being implemented

- drag&drop
- insert PCs (HOSTS) -> config ip/netmask/gw
- insert HUBs -> repeat signal
- insert ROUTERs -> configure at least two different interfaces
- establish connections between devices
- [...]

## Software architecture

- API Web server (dPT_server):
    * GET /projects/ -> returns projects list
    * GET /projects/:id -> returns project :id
    * PUT /projects/:id -> edits project :id
    * POST /projects/:id -> saves a new project called :id

- Database: 4 tables:
    * users(Laravel-implemented)
    * devices 
    * projects
    * interfaces 

## Issues

- Define API -> done
- Use a [canvas HTML5](https://www.w3schools.com/HTML/html5_canvas.asp) and save it on server -> to try [SVG conversion](http://www.svgopen.org/2010/papers/62-From_SVG_to_Canvas_and_Back/#canvas_to_svg)
