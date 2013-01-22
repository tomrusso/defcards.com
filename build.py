#!/usr/bin/python

import re
import subprocess

FILE_LIST = "files.txt"
OUT_DIR = "out"
TARGET_DIR = "/home/wanderin/www/defcards.com"

def get_file_contents(match_obj):
	f = open(match_obj.group(1))
	return f.read()

subprocess.call("rm -f " + OUT_DIR + "/*", shell=True)

f = open(FILE_LIST)
lines = [l.strip() for l in f.readlines() if(l.strip())]
f.close()

for filename in lines:
	f = open(filename)
	template = f.read()
	content = re.sub("<\s*%%%\s*(\S*)\s*%%%\s*>", get_file_contents, template)
	outfile = open(OUT_DIR + "/" + filename, 'w')
	outfile.write(content)
	outfile.close()
	f.close()

subprocess.call("rm -f " + TARGET_DIR + "/*", shell=True)
subprocess.call("cp " + OUT_DIR + "/* " + TARGET_DIR, shell=True)
subprocess.call("chmod g-w " + TARGET_DIR + "/*", shell=True)
