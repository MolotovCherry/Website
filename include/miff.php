<div class="magick-header">
<h1 class="text-center">Magick Image File Format</h1>
<p class="text-center"><a href="#miff-header">MIFF Header</a> • <a href="#binary">MIFF Binary Data</a></p>

<p class="lead magick-description">The Magick Image File Format (MIFF) is ImageMagick's own platform-independent format for storing bitmap images.  It has an advantage over other image formats in that it stores all metadata known to ImageMagick (e.g. image color profiles, comments, author, copyright, etc.), whereas, other formats may only support a small portion of available metadata or none at all.  A MIFF image file consist of two sections.  The first section is a header composed of keys describing the image in text form.  The next section is the binary image data.  We discuss these sections in detail below.</p>

<h2><a class="anchor" id="miff-header"></a>MIFF Header</h2>


<p>The MIFF header is composed entirely of ISO-8859-1 characters.  The fields in the header are key and value combination in the <var>key = value</var> format, with each key and value separated by an equal sign (<samp>=</samp>).  Each <var>key = value</var> combination is delimited by at least one control or whitespace character.  Comments may appear in the header section and are always delimited by braces.  The MIFF header always ends with a colon (<samp>:</samp>) character, followed by a <var>ctrl-Z</var> character.  It is also common to proceed the colon with a <var>formfeed</var> and a <var>newline</var> character.  The <var>formfeed</var> prevents the listing of binary data when using the <samp>more</samp> Linux program, whereas, the <var>ctrl-Z</var> has the same effect with the <samp>type</samp> command on the Windows command line.</p>

<p>The following is a partial list of <var> key = value</var> combinations that are typically be found in a MIFF file:</p>

<div class="table-responsive" style="font-size:smaller !important;">
<table class="table table-sm table-hover">
  <tr>
    <td>background-color = <var>color</var></td>
    <td> </td>
  </tr>
  <tr>
    <td>border-color = <var>color</var></td>
    <td> </td>
  </tr>
  <tr>
    <td>matte-color = <var>color</var></td>
    <td>these optional keys reflect the image background, border, and matte colors respectively.  A <a href="<?php echo $_SESSION['RelativePath']?>/../script/color.php">color</a> can be a name (e.g. white) or a hex value (e.g. #ccc).</td>
  </tr>
  <tr>
    <td>class = { DirectClass, PseudoClass }</td>
    <td>the type of binary pixel data stored in the MIFF file.  If this key is not present, DirectClass pixel data is assumed.</td>
  </tr>
  <tr>
    <td>colors = <var> value</var></td>
    <td>the number of colors in a DirectClass image. For a PseudoClass image, this key specifies the number of entries in the colormap.  If this key is not present in the header, and the image is PseudoClass, a linear 256 color grayscale colormap is assumed.  The maximum number of colormap entries is 65536.</td>
  </tr>
  <tr>
    <td>colorspace = { RGB, CMYK, ... }</td>
    <td>the colorspace of the pixel data.  The default is RGB.</td>
  </tr>
  <tr>
    <td>columns = value</td>
    <td>the width of the image in pixels.  This a required key and has no default value.</td>
  </tr>
  <tr>
    <td>compression = {BZip, None, Zip, ... }</td>
    <td>the type of algorithm used to compress the image data.  If this key is not present, the pixel data is assumed to be uncompressed.</td>
  </tr>
  <tr>
    <td>delay = <var>microseconds</var></td>
    <td>the interframe delay in an image sequence in microseconds.</td>
  </tr>
  <tr>
    <td>depth = { 8, 16, 32 }</td>
    <td>the depth of a single color value representing values from 0 to 255 (depth 8), 0 - 65535 (depth 16), or 0 - 4294967295 (depth 32).  If this key is absent, a depth of 8 is assumed.</td>
  </tr>
  <tr>
    <td>dispose = <var>value</var></td>
    <td>layer disposal method.  Here are the valid values:
	  <ul>
	    <dd class="col-md-8">0. No disposal specified.</dd>
  	  <dd class="col-md-8">1. Do not dispose between frames.</dd>
  	  <dd class="col-md-8">2. Overwrite frame with background color from header.</dd>
  	  <dd class="col-md-8">3. Overwrite with previous frame.</dd>
  	</ul>
    </td>
  </tr>
  <tr>
    <td>gamma = <var>value</var></td>
    <td>the gamma of the image.  If it is not specified, a gamma of 1.0 (linear brightness response) is assumed.</td>
  </tr>
  <tr>
    <td>id=ImageMagick</td>
    <td>identifies the file as a MIFF-format image file.  This key is required, must be the first key-value pair, can only appear once, and has no default.  Although this key can appear anywhere in the header, it should start as the first key of the header in column 1.  This will allow programs like <samp>file</samp>(1) to easily identify the file as MIFF.</td>
	</tr>
	<tr>
    <td>iterations = <var>value</var></td>
    <td>the number of times an image sequence loops before stopping.</td>
  </tr>
	<tr>
    <td>label = { <var>string </var>]</td>
    <td>defines a short title or caption for the image.  If any whitespace appears in the label, it must be enclosed within braces.</td>
  </tr>
	<tr>
    <td>matte = { True, False }</td>
    <td>specifies whether a the image has matte data.  Matte data is generally useful for image compositing.</td>
  </tr>
	<tr>
    <td>montage = <var>&lt;width&gt;x&lt;height&gt;[+-]&lt;x offset&gt;[+-]&lt;y offset&gt;</var></td>
  <td>size and location of the individual tiles of a composite image.
  Use this key when the image is a composite of a number of different tiles.  A tile consists of an image and optionally a border and a label.  <var>Width</var> is the size in pixels of each individual tile in the horizontal direction and <var>height</var> is the size in the vertical direction.  Each tile must have an equal number of pixels in width and equal in height.  However, the width can differ from the height.  <var>X offset</var> is the offset in number of pixels from the vertical edge of the composite image where the first tile of a row begins and <var>y offset</var> is the offset from the horizontal edge where the first tile of a column begins.  If this key is specified, a directory of tile names must follow the image header.  The format of the directory is explained below.</td>
  </tr>
	<tr>
    <td>page = <var>value</var></td>
    <td>preferred size and location of an image canvas.</td>
  </tr>
	<tr>
    <td>profile-icc = <var>value</var></td>
    <td>the number of bytes in the International Color Consortium color profile.  The profile is defined by the ICC profile specification located at <a href="http://www.color.org/icc_specs2.html">http://www.color.org/icc_specs2.html</a>.</td>
  </tr>
    <td>red-primary = <var>x,y</var></td>
    <td> </td>
	<tr>
    <td>green-primary = <var>x,y</var></td>
    <td> </td>
  </tr>
    <td>blue-primary = <var>x,y</var></td>
    <td> </td>
	<tr>
    <td>white-point = <var>x,y</var></td>
    <td>this optional key reflects the chromaticity primaries and white point.</td>
  </tr>
	<tr>
    <td>rendering-intent = { saturation, perceptual, absolute, relative }</td>
    <td>Rendering intent is the CSS-1 property that has been defined by the International Color Consortium (<a href="http://www.color.org">http://www.color.org</a>).</td>
  </tr>
	<tr>
    <td>resolution = <var>&lt;x-resolution&gt;x&lt;y-resolution&gt;</var></td>
    <td>vertical and horizontal resolution of the image.  See units for the specific resolution units (e.g. pixels per inch).</td>
  </tr>
	<tr>
    <td>rows = <var>value</var></td>
    <td>the height of the image in pixels.  This a required key and has no default value.</td>
  </tr>
	<tr>
    <td>scene = <var>value</var></td>
    <td>the sequence number for this MIFF image file.  This optional key is useful when a MIFF image file is one in a sequence of files used in an animation.</td>
  </tr>
	<tr>
    <td>signature = <var>value</var></td>
    <td>this optional key contains a string that uniquely identifies the image pixel contents.  NIST's SHA-256 message digest algorithm is recommended.</td>
  </tr>
	<tr>
    <td>units = { pixels-per-inch, pixels-per-centimeter }</td>
    <td>image resolution units.</td>
  </tr>
</table></div>

<p>Other key value pairs are permitted.  If a value contains whitespace it must be enclosed with braces as illustrated here:</p>

<pre class="bg-light text-dark mx-4"><samp>id=ImageMagick
class=PseudoClass  colors=256  matte=False
columns=1280  rows=1024  depth=8
compression=RLE
colorspace=RGB
copyright={© 1999-2017 ImageMagick Studio LLC}
&#8942;
</samp></pre>

<p>Note that <var>key = value</var> combinations may be separated by <var>newlines</var> or spaces and may occur in any order within the header.  Comments (within braces) may appear anywhere before the colon.</p>

<p>If you specify the montage key in the header, follow the header with a directory of image tiles.  This directory consists of a name for each tile of the composite image separated by a <var>newline</var> character.  The list is terminated with a NULL character.</p>

<p>If you specify the color-profile key in the header, follow the header (or montage directory if the montage key is in the header) with the binary color profile.</p>

<p>The header is separated from the image data by a <samp>:</samp> character immediately followed by a <var>newline</var>.</p>

<h2><a class="anchor" id="binary"></a>MIFF Binary Data</h2>

<p>Next comes the binary image data itself.  How the image data is formatted depends upon the class of the image as specified (or not specified) by the value of the class key in the header.</p>

<p>DirectClass images are continuous-tone, images stored as RGB (red, green, blue), RGBA (red, green, blue, alpha), CMYK (cyan, yellow, magenta, black), or CMYKA (cyan, yellow, magenta, black, alpha)  intensity values as defined by the colorspace key. Each intensity value is one byte in length for images of depth 8 (0..255), two bytes for a depth of 16 (0..65535), and images of depth 32 (0..4294967295) require four bytes in most significant byte first order.</p>

<p>PseudoClass images are colormapped RGB images. The colormap is stored as a series of red, green, and blue pixel values, each value being a byte in size. If the image depth is 16, each colormap entry consumes two bytes with the most significant byte being first. The number of colormap entries is defined by the colors key.  The colormap data occurs immediately following the header (or image directory if the montage key is in the header). PseudoClass image data is an array of index values into the color map. If there are 256
or fewer colors in the image, each byte of image data contains an index value. If the image contains more than 256 colors or the image depth is 16, the index value is stored as two contiguous bytes with the most significant byte being first. If matte is true, each colormap index is followed by a 1 or 2-byte alpha value.</p>

<p>The image pixel data in a MIFF file may be uncompressed, runlength encoded, Zip compressed, or BZip compressed. The compression key in the header defines how the image data is compressed. Uncompressed pixels are stored one scanline at a time in row order. Runlength-encoded compression counts runs of identical adjacent pixels and stores the pixels followed by a length byte (the number of identical pixels minus 1). Zip and BZip compression compresses each row of an image and precedes the compressed row with the length of compressed pixel bytes as a word in most significant byte first order.</p>

<p>MIFF files may contain more than one image.  Simply concatenate each individual image (composed of a header and image data) into one file.</p>

</div>
