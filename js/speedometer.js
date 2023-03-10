function draw(iSpeed)
{
    /* Main entry point for drawing the speedometer
    * If canvas is not support alert the user.
    */
    alert('');
    var canvas = document.getElementById('tutorial');
 
    // Canvas good?
    if (canvas != null && canvas.getContext)
    {
        var options = buildOptionsAsJSON(canvas, iSpeed);
 
        // Clear canvas
        clearCanvas(options);
 
        // Draw the metallic styled edge
        drawMetallicArc(options);
 
        // Draw thw background
        drawBackground(options);
 
        // Draw tick marks
        drawTicks(options);
 
        // Draw labels on markers
        drawTextMarkers(options);
 
        // Draw speeometer colour arc
        drawSpeedometerColourArc(options);
 
        // Draw the needle and base
        drawNeedle(options);
 
    }
    else
    {
        alert("Canvas not supported by your browser!");
    }
}

function drawMetallicArc(options)
{
    /* Draw the metallic border of the speedometer
     * by drawing two semi-circles, one over lapping
     * the other with a bit of alpha transparency
     */
 
    drawOuterMetallicArc(options);
    drawInnerMetallicArc(options);
}

function drawOuterMetallicArc(options)
{
    /* Draw the metallic border of the speedometer
     * Outer grey area
     */
    options.ctx.beginPath();
 
    // Nice shade of grey
    options.ctx.fillStyle = "rgb(127,127,127)";
 
    // Draw the outer circle
    options.ctx.arc(options.center.X,
        options.center.Y,
        options.radius,
        0,
        Math.PI,
        true);
 
    // Fill the last object
    options.ctx.fill();
}
 
function drawInnerMetallicArc(options)
{
    /* Draw the metallic border of the speedometer
     * Inner white area
     */
 
    options.ctx.beginPath();
 
    // White
    options.ctx.fillStyle = "rgb(255,255,255)";
 
    // Outer circle (subtle edge in white->grey)
    options.ctx.arc(options.center.X,
                    options.center.Y,
                    (options.radius / 100) * 90,
                    0,
                    Math.PI,
                    true);
 
    options.ctx.fill();
}

function drawBackground(options)
{
    /* Black background with alphs transparency to
     * blend the edges of the metallic edge and
     * black background
     */
 
    options.ctx.globalAlpha = 0.2;
    options.ctx.fillStyle = "rgb(0,0,0)";
 
    // Draw semi-transparent circles
    for (var i = 170; i < 180 ; i++)
    {
        options.ctx.beginPath();
 
        options.ctx.arc(options.center.X,
            options.center.Y,
            1 * i, 0,
            Math.PI,
            true);
 
        options.ctx.fill();
    }
}

function drawTicks(options)
{
    /* Two tick in the coloured arc!
     * Small ticks every 5
     * Large ticks every 10
     */
 
    drawSmallTickMarks(options);
    drawLargeTickMarks(options);
}

function drawSmallTickMarks(options)
{
    /* The small tick marks against the coloured
     * arc drawn every 5 mph from 10 degrees to
     * 170 degrees.
     */
 
    var tickvalue = options.levelRadius - 8;
    var iTick = 0;
    var gaugeOptions = options.gaugeOptions;
    var iTickRad = 0;
 
    applyDefaultContextSettings(options);
 
    // Tick every 20 degrees (small ticks)
    for (iTick = 10; iTick < 180; iTick += 20)
    {
        iTickRad = degToRad(iTick);
 
        /* Calculate the X and Y of both ends of the
         * line I need to draw at angle represented at Tick.
         * The aim is to draw the a line starting on the
         * coloured arc and continueing towards the outer edge
         * in the direction from the center of the gauge.
         */
 
        var onArchX = gaugeOptions.radius - (Math.cos(iTickRad) * tickvalue);
        var onArchY = gaugeOptions.radius - (Math.sin(iTickRad) * tickvalue);
        var innerTickX = gaugeOptions.radius - (Math.cos(iTickRad) * gaugeOptions.radius);
        var innerTickY = gaugeOptions.radius - (Math.sin(iTickRad) * gaugeOptions.radius);
 
        var fromX = (options.center.X - gaugeOptions.radius) + onArchX;
        var fromY = (gaugeOptions.center.Y - gaugeOptions.radius) + onArchY;
 
        var toX = (options.center.X - gaugeOptions.radius) + innerTickX;
        var toY = (gaugeOptions.center.Y - gaugeOptions.radius) + innerTickY;
 
        // Create a line expressed in JSON
        var line = createLine(fromX, fromY, toX, toY, "rgb(127,127,127)", 3, 0.6);
 
        // Draw the line
        drawLine(options, line);
 
    }
}
 
function drawLargeTickMarks(options)
{
    /* The large tick marks against the coloured
     * arc drawn every 10 mph from 10 degrees to
     * 170 degrees.
     */
 
    var tickvalue = options.levelRadius - 8;
    var iTick = 0;
    var gaugeOptions = options.gaugeOptions;
    var iTickRad = 0;
 
    var innerTickY;
    var innerTickX;
    var onArchX;
    var onArchY;
 
    var fromX;
    var fromY;
 
    var toX;
    var toY;
    var line;
 
    applyDefaultContextSettings(options);
 
    tickvalue = options.levelRadius - 2;
 
    // 10 units (major ticks)
    for (iTick = 20; iTick < 180; iTick += 20)
    {
        iTickRad = degToRad(iTick);
 
        /* Calculate the X and Y of both ends of the
         * line I need to draw at angle represented at Tick.
         * The aim is to draw the a line starting on the
         * coloured arc and continueing towards the outer edge
         * in the direction from the center of the gauge.
         */
 
        onArchX = gaugeOptions.radius - (Math.cos(iTickRad) * tickvalue);
        onArchY = gaugeOptions.radius - (Math.sin(iTickRad) * tickvalue);
        innerTickX = gaugeOptions.radius - (Math.cos(iTickRad) * gaugeOptions.radius);
        innerTickY = gaugeOptions.radius - (Math.sin(iTickRad) * gaugeOptions.radius);
 
        fromX = (options.center.X - gaugeOptions.radius) + onArchX;
        fromY = (gaugeOptions.center.Y - gaugeOptions.radius) + onArchY;
 
        toX = (options.center.X - gaugeOptions.radius) + innerTickX;
        toY = (gaugeOptions.center.Y - gaugeOptions.radius) + innerTickY;
 
        // Create a line expressed in JSON
        line = createLine(fromX, fromY, toX, toY, "rgb(127,127,127)", 3, 0.6);
 
        // Draw the line
        drawLine(options, line);
    }
}

function drawTextMarkers(options)
{
    /* The text labels marks above the coloured
     * arc drawn every 10 mph from 10 degrees to
     * 170 degrees.
     */
 
    var innerTickX = 0;
    var innerTickY = 0;
    var iTick = 0;
    var gaugeOptions = options.gaugeOptions;
    var iTickToPrint = 0;
 
    applyDefaultContextSettings(options);
 
    // Font styling
    options.ctx.font = 'italic 10px sans-serif';
    options.ctx.textBaseline = 'top';
 
    options.ctx.beginPath();
 
    // Tick every 20 (small ticks)
    for (iTick = 10; iTick < 180; iTick += 20)
    {
        innerTickX = gaugeOptions.radius - (Math.cos(degToRad(iTick)) * gaugeOptions.radius);
        innerTickY = gaugeOptions.radius - (Math.sin(degToRad(iTick)) * gaugeOptions.radius);
 
        // Some cludging to center the values (TODO: Improve)
        if(iTick        {
            options.ctx.fillText(iTickToPrint, (options.center.X - gaugeOptions.radius - 12) + innerTickX,
                    (gaugeOptions.center.Y - gaugeOptions.radius - 12) + innerTickY + 5);
        }
        if(iTick < 50)
        {
            options.ctx.fillText(iTickToPrint, (options.center.X - gaugeOptions.radius - 12) + innerTickX - 5,
                    (gaugeOptions.center.Y - gaugeOptions.radius - 12) + innerTickY + 5);
        }
        else if(iTick < 90)
        {
            options.ctx.fillText(iTickToPrint, (options.center.X - gaugeOptions.radius - 12) + innerTickX,
                    (gaugeOptions.center.Y - gaugeOptions.radius - 12) + innerTickY );
        }
        else if(iTick == 90)
        {
            options.ctx.fillText(iTickToPrint, (options.center.X - gaugeOptions.radius - 12) + innerTickX + 4,
                    (gaugeOptions.center.Y - gaugeOptions.radius - 12) + innerTickY );
        }
        else if(iTick < 145)
        {
            options.ctx.fillText(iTickToPrint, (options.center.X - gaugeOptions.radius - 12) + innerTickX + 10,
                    (gaugeOptions.center.Y - gaugeOptions.radius - 12) + innerTickY );
        }
        else
        {
            options.ctx.fillText(iTickToPrint, (options.center.X - gaugeOptions.radius - 12) + innerTickX + 15,
                    (gaugeOptions.center.Y - gaugeOptions.radius - 12) + innerTickY + 5);
        }
 
        // MPH increase by 10 every 20 degrees
            iTickToPrint += 10;
    }
 
    options.ctx.stroke();
 
}

function drawSpeedometerColourArc(options)
{
    /* Draws the colour arc.  Three different colours
     * used here; thus, same arc drawn 3 times with
     * different colours.
     * TODO: Gradient possible?
     */
 
    var startOfGreen = 10;
    var endOfGreen = 200;
    var endOfOrange = 280;
 
    drawSpeedometerPart(options, 1.0, "rgb(82, 240, 55)", startOfGreen);
    drawSpeedometerPart(options, 0.9, "rgb(198, 111, 0)", endOfGreen);
    drawSpeedometerPart(options, 0.9, "rgb(255, 0, 0)", endOfOrange);
 
}

function drawNeedleDial(options, alphaValue, strokeStyle, fillStyle)
{
    /* Draws the metallic dial that covers the base of the
    * needle.
    */
 
    options.ctx.globalAlpha = alphaValue
    options.ctx.lineWidth = 3;
    options.ctx.strokeStyle = strokeStyle;
    options.ctx.fillStyle = fillStyle;
 
    // Draw several transparent circles with alpha
    for (var i = 0;i < 30; i++)
    {
        options.ctx.beginPath();
 
        options.ctx.arc(options.center.X,
            options.center.Y,
            1*i,
            0,
            Math.PI,
            true);
 
        options.ctx.fill();
 
        options.ctx.stroke();
    }
}

function drawNeedle(options)
{
    /* Draw the needle in a nice read colour at the
    * angle that represents the options.speed value.
    */
 
    var iSpeedAsAngle = convertSpeedToAngle(options);
    var iSpeedAsAngleRad = degToRad(iSpeedAsAngle);
 
    var gaugeOptions = options.gaugeOptions;
 
    var innerTickX = gaugeOptions.radius - (Math.cos(iSpeedAsAngleRad) * 20);
    var innerTickY = gaugeOptions.radius - (Math.sin(iSpeedAsAngleRad) * 20);
 
    var fromX = (options.center.X - gaugeOptions.radius) + innerTickX;
    var fromY = (gaugeOptions.center.Y - gaugeOptions.radius) + innerTickY;
 
    var endNeedleX = gaugeOptions.radius - (Math.cos(iSpeedAsAngleRad) * gaugeOptions.radius);
    var endNeedleY = gaugeOptions.radius - (Math.sin(iSpeedAsAngleRad) * gaugeOptions.radius);
 
    var toX = (options.center.X - gaugeOptions.radius) + endNeedleX;
    var toY = (gaugeOptions.center.Y - gaugeOptions.radius) + endNeedleY;
 
    var line = createLine(fromX, fromY, toX, toY, "rgb(255,0,0)", 5, 0.6);
 
    drawLine(options, line);
 
    // Two circle to draw the dial at the base (give its a nice effect?)
    drawNeedleDial(options, 0.6, "rgb(127, 127, 127)", "rgb(255,255,255)");
    drawNeedleDial(options, 0.2, "rgb(127, 127, 127)", "rgb(127,127,127)");
 
}
