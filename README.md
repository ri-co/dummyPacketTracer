# dummyPacketTracer
Just a tiny and simple web application that allows to create network topologies. For educational purposes.

Start of the project: 2017

## Functions being implemented

- drag&drop
- insert PCs (HOSTS) -> config ip/netmask/gw
- inserire hub -> repeat signal
- inserire router -> configure at least two different interfaces
- stabilire collegamenti tra dispositivi
- [...]

## Software architecture

- API Web server (dPT_server):
    * GET /projects/ -> returns projects list
    * GET /projects/:id -> returns project :id
    * PUT /projects/:id -> edit il project :id
    * POST /projects/:id -> save a new project called :id

- Database: 4 tables:
    * users(Laravel-implemented)
    * devices 
    * projects
    * interfaces 

## Issues

- Define API -> done
- Use a [canvas HTML5](https://www.w3schools.com/HTML/html5_canvas.asp) and save it on server -> to try [conversione in SVG](http://www.svgopen.org/2010/papers/62-From_SVG_to_Canvas_and_Back/#canvas_to_svg)
