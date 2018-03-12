'''
Created on 2018-3-3

@author: Administrator
'''
from random import Random
import getopt
import os
import re
import sys
import traceback


workroot = os.path.dirname(os.path.abspath(__file__))


postfix = '''
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
'''

def RandomLowerStr(randomlength=8):
    chars = 'abcdefghijklmnopqrstuvwxyz'
    length = len(chars) - 1
    random = Random()
    s = str(chars[random.randint(1, length)])
    for _ in range(randomlength - 1):
        s += chars[random.randint(0, length)]
    return s

def parse_table_name(txt, prefix):
    m = re.search(r'CREATE[ ]+TABLE[ ]+IF[ ]+NOT[ ]+EXISTS[ ]+[`]?([\w_]+)[`]?', txt)
    if m:
        table_name = m.group(1)
    else:
        m = re.search(r'USE[ ]+[`]?([\w_]+)[`]?;', txt)
        if m:
            table_name = m.group(1)
        else:
            table_name = RandomLowerStr(8)
    return '%s.sql'%(table_name.replace(prefix, ''))

def save_file(ouput_folder, txt, table_prefix):
    filename = parse_table_name(txt, table_prefix)
    filename = os.path.join(ouput_folder, filename)
    with open(filename, 'w') as f:
        f.writelines(txt)

def parse_sql(sql_file_path, ouput_folder, table_prefix):
    arr = []
    with open(sql_file_path,'r') as f:
        for line in f:
            if len(arr) == 0:
                arr.append(line)
            else:
                m = re.match('--[ ]*[-]+', line)
                if m:
                    save_file(ouput_folder, ''.join(arr), table_prefix)
                    arr =[line]
                else:
                    arr.append(line)
    if arr:
        save_file(ouput_folder, ''.join(arr), table_prefix)
                    
def join_sql(sql_folder, database_filename):
    dirs = os.listdir(sql_folder)
    data = {}
    
    # load yaml file
    for filename in dirs:
        if not filename.endswith('.sql'):
            continue
        file_path = os.path.join(sql_folder, filename)
        if not os.path.isfile(file_path):
            continue
        
        tmp = []
        with open(file_path, 'r') as f:
            for line in f:
                if line[0:2] == '--':
                    continue
                else:
                    tmp.append(line)
            data[filename] = ''.join(tmp)
            
    keys = data.keys()
    keys.sort()
    
    arr = []
    if database_filename:
        arr.append(data[database_filename])

    for key in keys:
        if key == database_filename:
            continue
        arr.append(data[key])
        
    arr.append(postfix)
            
    output = os.path.join(workroot, 'data.sql')
    with open(output, 'w') as f:
        f.writelines('\n'.join(arr))
        
def main():
    try:
        opts, args = getopt.getopt(sys.argv[1:], "jph", ["join","parse","help"])
    except getopt.GetoptError:
        usage()
        sys.exit(2)
    for opt, _ in opts:
        if opt in ("-h", "--help"):
            usage()
            sys.exit()
        elif opt in ("-j","--join"):
            join(*args)
            sys.exit()
        elif opt in ("-p","--parse"):
            parse(*args)
            sys.exit()            
        

def usage():
    print "-h  --help  show help"
    print "python mysql.py -j sql_script_folder  database_filename"
    print "python mysql.py -p sql_file_path output_folder table_prefix"
    print "python mysql.py -h "
    

def join(folder, database_filename=''):
    try:
        output = os.path.join(workroot, folder)
        if os.path.isdir(output):
            join_sql(output, database_filename)
        else:
            print 'The sql fold not exist'
    except:
        traceback.print_exc()
        
def parse(sql_file_path, folder='sql', table_prefix='o_'):
    try:
        output = os.path.join(workroot, folder)
        if not os.path.isdir(output):
            os.mkdir(output)
        parse_sql(sql_file_path, output, table_prefix)
    except:
        traceback.print_exc()
             
if __name__ == "__main__":
    main()             