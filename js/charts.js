var CHARTS = CHARTS || (function() {
	var _args = {};
	return {
		init : function(Args) {
			_args = Args;
        	},
		radarchart: function() {
			// generate point sequence
			function linspace(x0, xN, n) {
				dx = (xN - x0) / (n-1);
				var x = [];
				for(var i=0; i < n; ++i) {
					x.push(x0 + i*dx);
				}
				return x;
			}

			// scale values
			// NewValue = (((OldValue - OldMin) * (NewMax - NewMin)) / (OldMax - OldMin)) + NewMin
			function scale(oldMin, oldMax, oldVal) {
				oldVal = oldVal || oldMin;
				if ((oldMax - oldMin)==0)
					var newVal = 0;
				else
					var newVal = (oldVal - oldMin) / (oldMax - oldMin);
				return newVal;
			}

			// create the plot
			var plt = Bokeh.Plotting;

			// configure the plot
			var tools = "pan,wheel_zoom,box_zoom,reset,save";
			var p = plt.figure({
				tools: tools,
				x_range: [-0.1, 1.3],
				y_range: [-0.1, 1.3],
				x_axis_type: null,
				y_axis_type: null
			});

			// create the multi circle mesh
			var rad = linspace(0, 0.5, 11);
			var theta = linspace(5*Math.PI/8, 21*Math.PI/8, 9);

			var xsp = [];
			var ysp = [];

			rad.forEach((r) => {
				var x = [];
				var y = [];
				theta.forEach((t) => {
					x.push(r*Math.cos(t) + 0.5);
					y.push(r*Math.sin(t) + 0.5);
				})
				xsp.push(x);
				ysp.push(y);
			})

			var x = [];
			var y = [];
			for(var i=0; i < 4; ++i) {
				x.push([xsp[xsp.length - 1][i], xsp[xsp.length - 1][i+4]]);
				y.push([ysp[ysp.length - 1][i], ysp[ysp.length - 1][i+4]]);
			}

			// add a multi circle mesh to plot
			var mesh_source = new Bokeh.ColumnDataSource({data: {xs: xsp.concat(x), ys: ysp.concat(y)}});
			var multi_line = new Bokeh.MultiLine({
				xs: {field: "xs"},
				ys: {field: "ys"},
				line_color: "gray",
				line_width: 3,
				line_alpha: 0.1
			});
			p.add_glyph(multi_line, mesh_source);

			// add crosshair to plot
			var crosshair_source = new Bokeh.ColumnDataSource({data: {xs: [[0.5, 0.5], [0, 1]], ys: [[0, 1], [0.5, 0.5]]}});
			var multi_line = new Bokeh.MultiLine({
				xs: {field: "xs"},
				ys: {field: "ys"},
				line_color: "gray",
				line_width: 3,
				line_alpha: 0.1,
				line_dash: [6],
				line_dash_offset: 0
			});
	 		p.add_glyph(multi_line, crosshair_source);

			// add operating figures labels
			var labels = ["B.4.3.1", "B.4.2.3", "B.3.4.1", "B.3.1.2", "B.2.2.5", "B.2.2.1", "B.1.4.1", "B.1.3.2", ""];
			var label_source = new Bokeh.ColumnDataSource({data: {x: xsp[xsp.length - 1], y: ysp[ysp.length - 1], text: labels}});
			var label_set = new Bokeh.LabelSet({
				x: {field: "x"},
				y: {field: "y"},
				text: {field: "text"},
				text_alpha: 0.6,
				text_align: "center",
				source: label_source
			});
			p.add_layout(label_set);

			// add percentage marks
			var percents = ["20%", "40%", "60%", "80%"];
			var percent_source = new Bokeh.ColumnDataSource({data: {x: [0.51, 0.51, 0.51, 0.51],  y: linspace(0.59, 0.869, 4), text: percents}});
			var label_set = new Bokeh.LabelSet({
				x: {field: "x"},
				y: {field: "y"},
				text: {field: "text"},
				text_alpha: 0.6,
				text_align: "center",
				source: percent_source
			});
			p.add_layout(label_set);

			// add quarter marks
			var quarters = ['III', 'II', 'IV', 'I'];
			var quarter_source = new Bokeh.ColumnDataSource({data: {x: [0, 1, 0, 1],  y: [0, 0, 1, 1], text: quarters}});
			var label_set = new Bokeh.LabelSet({
				x: {field: "x"},
				y: {field: "y"},
				text: {field: "text"},
				text_alpha: 0.6,
				text_align: "center",
				source: quarter_source
			});
			p.add_layout(label_set);

			// add library patches
			var patches = [];
			var medTemp = [];
			var valTemp = [];
			for(var i=0; i < 8; ++i) {
				medTemp.push(scale(_args[0][i], _args[1][i], _args[2][i]));
				if(typeof(_args[4]) != "undefined") {
					valTemp.push(scale(_args[0][i], _args[1][i], _args[3][i]));
				}
			}

			var colors = ["#B2B2B2", "#FA820A"];
			var bibsLabels = ["Median", _args[4]];

			patches.push(medTemp);
			if(typeof(_args[4]) != "undefined") {
				patches.push(valTemp);
			}

			var items = []
			var counter = 0;
			patches.forEach((patch) => {
				var xpt = [];
				var ypt = [];

				for(var i=0; i < 9; ++i) {
					xpt.push(patch[i]*Math.cos(theta[i])/2 + 0.5);
					ypt.push(patch[i]*Math.sin(theta[i])/2 + 0.5);
				}

				var patches_source = new Bokeh.ColumnDataSource({data: {x: xpt, y: ypt}});
				var patch_glyph = new Bokeh.Patch({
					x: {field: "x"},
					y: {field: "y"},
					fill_color: colors[counter],
					fill_alpha: 0.5,
					line_color: colors[counter],
					line_alpha: 1,
					line_width: 3
				});
			
				glyph_renderer = p.add_glyph(patch_glyph, patches_source);
				items.push(new Bokeh.LegendItem({label: bibsLabels[counter], renderers: [glyph_renderer]}));

				++counter;
			});

			// add legend plate with patches description
			items = items.reverse();	
			const legend = new Bokeh.Legend({items, location: "top_right"});
			p.add_layout(legend);

			// show the plot
			plt.show(p, '#radarchart');
		},
		
		boxplot: function() {

			function add_outliers(out_arr, outdatasrc, hide_b, show_b) {
				hide_b.style.display = 'block';
				show_b.style.display = 'none';
				var x_arr = out_arr[0];
				var y_arr = out_arr[1];
				outdatasrc.data.x = x_arr;
				outdatasrc.data.y = y_arr;
				outdatasrc.change.emit();
			}

			function del_outliers(outdatasrc, hide_b, show_b) {
				hide_b.style.display = 'none';
				show_b.style.display = 'block';
				var out_arr = [outdatasrc.data.x, outdatasrc.data.y];
				outdatasrc.data.x = [];
				outdatasrc.data.y = [];
				outdatasrc.change.emit();
				return (out_arr);
			}

			// create the plot
            var plt = Bokeh.Plotting;

            // configure the plot
            const tools = "pan,wheel_zoom,box_zoom,reset,save";
			const yr = new Bokeh.DataRange1d({start: 0})
            var p = plt.figure({
                tools: tools,
				plot_width: 150 * Object.keys(_args[1]).length,
				y_range: yr
           });
			p.xaxis[0].ticker.desired_num_ticks = Object.keys(_args[1]).length;
			p.xgrid[0].grid_line_color = null;
			p.ygrid[0].grid_line_color = null;

			// add boxes to plot
			var x = [];
			var btm = [];
			var mid = [];
			var top = [];
			Object.keys(_args[1]).forEach(function(key,index) {
				x.push(parseInt(key));
				btm.push(parseFloat(_args[1][key][0]));
				mid.push(parseFloat(_args[1][key][1]));
				top.push(parseFloat(_args[1][key][2]));
			});

			var lower_box_source = new Bokeh.ColumnDataSource({data: {x: x, top: mid, bottom: btm}});
			var higher_box_source = new Bokeh.ColumnDataSource({data: {x: x, top: top, bottom: mid}});
			var box_glyph = new Bokeh.VBar({
				x: {field: "x"},
				top: {field: "top"},
				bottom: {field: "bottom"},
				width: 0.75,
				fill_color: "#B2B2B2",
				fill_alpha: 0.4,
				line_color: "#A2A2A2",
				line_alpha: 0.8,
				line_width: 3
           }); 
			p.add_glyph(box_glyph, lower_box_source);
			p.add_glyph(box_glyph, higher_box_source);

			// add stems to plot
			var x = [];
			var y_btm = [];
			var y_top = [];
			Object.keys(_args[2]).forEach(function(key,index) {
				x.push(parseInt(key));
				y_btm.push(parseFloat(_args[2][key][0]));
				y_top.push(parseFloat(_args[2][key][1]));
			});

			var lower_stem_source = new Bokeh.ColumnDataSource({data: {x0: x, y0: y_btm, x1: x, y1: btm}});
			var higher_stem_source = new Bokeh.ColumnDataSource({data: {x0: x, y0: top, x1: x, y1: y_top}});
			var stem_glyph = new Bokeh.Segment({
				x0: {field: "x0"},
				y0: {field: "y0"},
				x1: {field: "x1"},
				y1: {field: "y1"},
				line_color: "black",
				line_alpha: 0.8,
				line_width: 3
           }); 
			p.add_glyph(stem_glyph, lower_stem_source);
			p.add_glyph(stem_glyph, higher_stem_source);

			// add whisker to plot
			var lower_whisker_source = new Bokeh.ColumnDataSource({data: {x0: x.map(function(value){return value-0.15;}), y0: y_btm, x1: x.map(function(value){return value+0.15;}), y1: y_btm}});
			var higher_whisker_source = new Bokeh.ColumnDataSource({data: {x0: x.map(function(value){return value-0.15;}), y0: y_top, x1: x.map(function(value){return value+0.15;}), y1: y_top}});
			var whisker_glyph = new Bokeh.Segment({
				x0: {field: "x0"},
				y0: {field: "y0"},
				x1: {field: "x1"},
				y1: {field: "y1"},
				line_color: "black",
				line_alpha: 0.8,
				line_width: 3
           }); 
			p.add_glyph(whisker_glyph, lower_whisker_source);
			p.add_glyph(whisker_glyph, higher_whisker_source);

			// add outliers to plot
			var out_x = [];
			var out_y = [];
			Object.keys(_args[3]).forEach(function(key,index) {
				_args[3][key].forEach(function(element) {
					out_x.push(parseInt(key));
					out_y.push(parseFloat(element));
				});
			});

			var outliers_source = new Bokeh.ColumnDataSource({data: {x: out_x, y: out_y}});
			var outliers_circles = new Bokeh.Circle({
				x: {field: "x"},
				y: {field: "y"},
				size: 5,
				fill_alpha: 0.4,
				fill_color: "#787878",
				line_alpha: 0.4,
				line_width: 3
           }); 
			p.add_glyph(outliers_circles, outliers_source);

			// add library points
			var x = [];
			var y = [];
			Object.keys(_args[4]).forEach(function(key,index) {
				x.push(parseInt(key));
				y.push(parseFloat(_args[4][key][0]));
			});
			var libpoints_source = new Bokeh.ColumnDataSource({data: {x: x, y: y}});
			var libpoints_line = new Bokeh.Line({
				xs: {field: "x"},
				ys: {field: "y"},
				line_color: "#FA820A",
				line_width: 3,
				line_alpha: 1
			});
			p.add_glyph(libpoints_line, libpoints_source);

			var libpoints_circles = new Bokeh.Circle({
				x: {field: "x"},
				y: {field: "y"},
				size: 8,
				fill_color: "#FA820A",
				fill_alpha: 0.8,
				line_color: "black",
				line_alpha: 0.8,
				line_width: 3
           }); 
			p.add_glyph(libpoints_circles, libpoints_source);

			// show the plot
			var divName = '#boxplot_' + _args[0];
            plt.show(p, divName);

			// add buttons for show/hide outliers
			var temporary_outliers = [];

			var showButton = document.createElement("Button");
			showButton.setAttribute("id", "showOutliers");
			showButton.style.display = 'none';
            showButton.style.margin = 'auto';
            showButton.appendChild(document.createTextNode("Ausreißer anzeigen"));
			document.currentScript.parentElement.appendChild(showButton);
			showButton.addEventListener("click", () => add_outliers(temporary_outliers, outliers_source, hideButton, showButton));

            var hideButton = document.createElement("Button");
			hideButton.setAttribute("id", "hideOutliers");
			hideButton.style.display = 'block';
            hideButton.style.margin = 'auto';
            hideButton.appendChild(document.createTextNode("Ausreißer verstecken"));
			document.currentScript.parentElement.appendChild(hideButton);
			hideButton.addEventListener("click", () => temporary_outliers = del_outliers(outliers_source, hideButton, showButton));
		}
	};
}());
