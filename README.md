InspectPHP
==========
Visual debugging library for PHP developers. Expand/hide elements by clicking on them. All styles and scripts are inline so no interference will occur with your app.

#### Setup
Just include the inspect.php file in your project and call ```inspect($object)``` to render visual information about the object.

#### Themes
You can change the colourscheme by altering ```$scheme``` in the ```inspectStyle``` function - there are four built-in themes to choose from. It's easy to add your own styles, too; just append an of your colours to the ```$theme``` collection.

#### Feedback
Feel free to share questions/comments.

#### Example
Here we are calling ```inspect``` on an array of objects.

![Array Example](https://raw.githubusercontent.com/CraicOverflow89/InspectPHP/master/example/array.png "Array Example")
