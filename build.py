#!/usr/bin/python

from bokeh.plotting import figure, show
from bokeh.models import ColumnDataSource, LabelSet, Legend, LegendItem
from bokeh.embed import json_item
import numpy as np
import json
import csv

def radar_patch(r, theta):
	# xt = (r + 0.0001) * np.cos(theta) + 0.5
	# yt = (r + 0.0001) * np.sin(theta) + 0.5
	xt = r * np.cos(theta) + 0.5
	yt = r * np.sin(theta) + 0.5
	return xt, yt

def unit_poly_verts(theta, r):
	x0, y0 = [0.5] * 2
	verts = [(r * np.cos(t) + x0, r * np.sin(t) + y0) for t in theta]
	return verts

def chart_build(lib_id, lib_pt_list, med_pt_list):
	
	lib_name = lib_pt_list.pop(0)
	clabel = ["Median", lib_name]
	print (lib_name);

	theta = np.linspace(0, 2*np.pi, num_vars, endpoint=False)
	theta += np.pi/2
	rad = np.linspace(0, 0.5, rad_lines, endpoint=True)

	xsp = []
	ysp = []
	for r in rad:
		verts = unit_poly_verts(theta, r)
		x = [v[0] for v in verts]
		x.append(x[0])
		y = [v[1] for v in verts]
		y.append(y[0])
		xsp.append(x.copy())
		ysp.append(y.copy())
    
	for n in range(num_vars):
		rx=[]
		ry=[]
		for r in range(rad_lines):
			rx.append(xsp[r][n])
			ry.append(ysp[r][n])
		xsp.append(rx.copy())
		ysp.append(ry.copy())

	source = ColumnDataSource({	'x':xsp[-(rad_lines+2)] + xsp[-1][-rad_lines:],
					'y':ysp[-(rad_lines+2)] + ysp[-1][-rad_lines:],
					'text':text+percentage})
	p = figure(title="Radar Chart", toolbar_location="right", x_range=(-0.1, 1.2), y_range=(-0.1, 1.2))
	p.axis.visible = False
	p.grid.visible = False

	p.multi_line(xs=xsp, ys=ysp, line_alpha=0.1, line_color="gray")
	labels = LabelSet(x="x",y="y", text="text", text_alpha=0.4, source=source)
	p.add_layout(labels)

	f1 = np.array(med_pt_list) * 0.5
	f2 = np.array(lib_pt_list) * 0.5
	flist = [f1,f2]
	colors = ["orange","blue"]
	for i in range(len(flist)):
		xt, yt = radar_patch(flist[i], theta)
		p.patch(x=xt, y=yt, fill_alpha=0.4, legend_label=clabel[i], fill_color=colors[i])

	item_text = json.dumps(json_item(p, lib_id))
	print ("('{0}', '{1}', '{2}', '{3}'),".format(lib_id, '0', '2019', item_text))

def csv_reader(file_obj):
	csv_dict = {}
	reader = csv.DictReader(file_obj, delimiter=';')
	for row in reader:
		np_list = [row['Name']]
		for item in text:
			np_list.append(float(row[item]))			
		csv_dict[ row['DBS-ID'] ] = np_list
	return csv_dict

if __name__ == "__main__":
	
	csv_path = "scaled_np_arrays.txt"

	text = [	'B.1.2.4',
			'B.1.3.1',
			'B.1.3.2',
			'B.1.4.1',
			'B.2.2.1',
			'B.2.2.4',
			'B.2.2.5',
			'B.3.3.3',
			'B.3.4.1',
			'B.3.4.2',
			'B.4.2.2',
			'B.4.3.1'
		]

	percentage = ['','10%','20%','30%','40%','50%','60%','70%','80%','90%', '']
	num_vars=12
	rad_lines=11

	with open(csv_path, "r") as f_obj:
		c_dict = csv_reader(f_obj)
	
	c_dict['MED'].pop(0)
	text.append('')

	for key in c_dict:
		if not key == 'MED':
			chart_build(key, c_dict[key], c_dict['MED'])

