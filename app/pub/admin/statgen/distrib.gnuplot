set ticslevel 0
set title "Request distribution"
set term gif animate opt delay 40 size 600,600


set ydata time
set timefmt "%d/%b/%Y:%H:%M:%S"
set zlabel "Content"
set xlabel "IP address"

set cbrange [0:16999]

limit_iterations=72
xrot=45
xrot_delta = 0
zrot=136
zrot_delta = 355
xview(xrot)=xrot
zview(zrot)=zrot
set size square
set view xview(xrot), zview(zrot), 1, 1


splot "gnuplot.input" using 1:2:3:4 with points pt 3 ps 1 lc rgb variable title ""


iteration_count=0
xrot =(xrot+xrot_delta)%360
zrot =(zrot+zrot_delta)%360


load "gnuplot.rot"
