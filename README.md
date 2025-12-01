# Internal
### It's just a simple package, a script, written in php for personal use. I just want a speeddial like and a internal "site" that I'm going to link to from obs for different scenes, and a tiny homepage for my docker services


***

### Components(until now, will de updated):
- a tiny router(not for production) with named routes and attribute router;
- in the work of adding the fs part, extending spl file system classes and adding some methods to them;
- added a tiny system info class;
  - get the os we're running on(using the directory separator);
  - get the cpu usage;
  - get the memory capacity, free memory and used memory;
  - find if we're running on cli or not;
- to be added;

### To be added:
- some database abstraction layer;
- image processing library or build a tiny one;
- some fs(filesystem) capabilities(working on it);;
- controllers, models and stuff for website(this is an ongoing project, I'll always add some more stuff);
- front end stuff(js, css, layout etc);
- file upload(tied to fs and js);
- and more;


## And again this is not intended to be used in production(it's just for in house use)