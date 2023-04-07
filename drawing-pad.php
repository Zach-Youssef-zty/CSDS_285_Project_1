<head>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin = "anonymous" referrerpolicy = "no-referrer">
    </script>
</head>
<canvas id='drawingpad' style='height: 100vh; width: 100vw;'></canvas>
<button id='draw' style='position: absolute; top: 0; left: 0; z-index: 5; width: 50px;' disabled>
    Draw
</button>
<button id='erase' style='position: absolute; top: 0; left: 50px; z-index: 5; width: 50px;'>
    Eraser
</button>
<form id='size-form' style='z-index: 5; position: absolute; top: 0; left: 0; right: 0; margin: auto; width: fit-content;'>
    <label for='erase-size'>Eraser Size:</label>
    <input id='erase-size' type='number' name='erase-size' value='8'>
    <label for='pen-color'>Pen Color:</label>
    <input id='pen-color' type='color' name='pen-color' value='#000000'>
</form>
<button id='clear' style='position: absolute; top: 0; right: 0; z-index: 5;'>
    Clear Canvas
</button>
<button id='save' style='position: absolute; bottom: 0; left: 0; right: 0; margin: auto; width: fit-content; z-index: 5;'>
    Save Drawing
</button>
<script type='text/javascript'>
    var canvas = document.getElementById('drawingpad');
    var canvas2d = canvas.getContext('2d');
    var draw =  document.getElementById('draw');
    var erase =  document.getElementById('erase');
    var clear = document.getElementById('clear');
    var size = document.getElementById('erase-size');
    var sizeForm = document.getElementById('size-form');
    var color = document.getElementById('pen-color');
    var save = document.getElementById('save');
    var click = false;
    var drawing = true;
    var prevX = undefined;
    var prevY = undefined;
    var eraseSize = 8;
    function mouseDown(e) {
        click = true;
        prevX = e.pageX;
        prevY = e.pageY;
    }
    function mouseUp(e) {
        click = false;
    }
    function mouseMove(e) {
        if(click) {
            const canvasPixelConvertX = 300 / window.innerWidth;
            const canvasPixelConvertY = 150 / window.innerHeight;
            const convertPrevX = prevX * canvasPixelConvertX;
            const convertPrevY = prevY * canvasPixelConvertY;
            const convertX = e.pageX * canvasPixelConvertX;
            const convertY = e.pageY * canvasPixelConvertY;

            if(drawing) {
                canvas2d.beginPath();
                canvas2d.moveTo(convertPrevX, convertPrevY);
                canvas2d.lineTo(convertX, convertY);
                canvas2d.stroke();
                canvas2d.closePath();
            } else {
                canvas2d.clearRect(convertX-4, convertY-4, eraseSize, eraseSize);
            }

            prevX = e.pageX;
            prevY = e.pageY;
        }
    }
    function clickDraw(e) {
        drawing = true;
        draw.disabled = true;
        erase.disabled = false;
    }
    function clickErase(e) {
        drawing = false;
        draw.disabled = false;
        erase.disabled = true;
    }
    function clearCanvas(e) {
        canvas2d.clearRect(0, 0, 300, 150);
    }
    function setSize(e) {
        eraseSize = e.target.value == null ? 8 : e.target.value;
    }
    function setColor(e) {
        canvas2d.strokeStyle = e.target.value == null ? '#000000' : e.target.value;
    }
    function saveImage(e) {
        canvas.toBlob((blob) => {saveAs(blob, 'drawing.png')});
    }
    
    document.addEventListener('mousedown', mouseDown);
    document.addEventListener('mouseup', mouseUp);
    canvas.addEventListener('mousemove', mouseMove);
    draw.addEventListener('click', clickDraw);
    erase.addEventListener('click', clickErase);
    clear.addEventListener('click', clearCanvas);
    size.addEventListener('change', setSize);
    color.addEventListener('change', setColor);
    sizeForm.addEventListener('submit', (e) => {e.preventDefault();});
    save.addEventListener('click', saveImage);
</script>
