#!/usr/bin/python

import statistics
import json
import csv

def csv_reader(file_obj):
	csv_list = []
	reader = csv.DictReader(file_obj, delimiter=';')
	for row in reader:
		dbs_dict = {}
		dbs_dict['DBS-ID'] = row['DBS-ID']
		dbs_dict['Name'] = row['Name']
		for item in fields:
			dbs_dict[item] = row[item]
		csv_list.append(dbs_dict)
	return csv_list

def min_med_max_counter(csv_list):
	range_limits_dict={}
	min_dict = {}
	max_dict = {}
	med_dict = {'DBS-ID':'MED', 'Name':'Median'}

	for item in fields:
		m_list = []
		for line in csv_list:
			if (line[item]):
				m_list.append(float(line[item]))

		min_dict[item] = min(m_list)
		max_dict[item] = max(m_list)
		med_dict[item] = statistics.median(m_list)

	range_limits_dict['min'] = min_dict
	range_limits_dict['max'] = max_dict
	csv_list.append(med_dict)
	print (med_dict)

	return range_limits_dict

def scale_adjst(range_limits_dict, csv_list):
	for line in csv_list:
		print (line['DBS-ID'] + ';' + line['Name'] + ';', end='')
		for key in line:
			if not (key == 'DBS-ID' or key == 'Name'):
				print ("{:.4f}".format(float_convert(line[key]) / range_limits_dict['max'][key]) + ';', end='')
		print ()

def float_convert(s):
	return float(s) if s else 0.0

if __name__ == "__main__":
	
	csv_path = "dbs_2019.csv"
	fields = [	'B.1.2.4',
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
			'B.4.3.1'	]

	with open(csv_path, "r") as f_obj:
		c_list = csv_reader(f_obj)
	
	r_limits_dict = min_med_max_counter(c_list)
	print (r_limits_dict)
#	scale_adjst(r_limits_dict, c_list)

