import os
import zipfile
import rarfile
import errno

# Current directory
dir_path = os.getcwd()

def archive():
    # Combines the file name into the path information for a full file location
    path = root + '/' + name

    #Path to the archive
    archive = os.path.abspath(path)


def delete(archive):
    os.remove(archive)

def rename(extension, archive, root):
    if extension == 'zip':
        archive.rename(archive.with_suffix('.zip'))

        archive = archive()
        
        extract(extension, archive, root)

    elif extension == 'rar':
        archive.rename(archive.with_suffix('.rar'))

        archive = archive()

        extract(extension, archive, root)

def extract(extension, archive,root):

    if extension == 'zip':
        ref = zipfile.ZipFile(archive, 'r')
        array = [ref.namelist()]

    else:
        ref = rarfile.RarFile(archive, 'r')
        array = [ref.namelist()]

    for f in array[0]:
        if f.endswith('/'):
            try:
                #Extracts all and breaks the loop
                ref.extractall(root)
                break
            except(OSError, IOError) as err:
                if err.errno != errno.EEXIST:
                    raise
        elif not f.endswith('/') and not os.path.isdir(new_folder):
            try:
                #Creates a new directory to place the extracted files
                os.makedirs(new_folder)
                ref.extractall(new_folder)
            except OSError as exc:
                if exc.errno == errno.EEXIST and os.path.isdir(new_folder):
                    pass

# root provides all path information, files returns actual file name + extension
for root, dirs, files in os.walk(dir_path):
    for name in files:

        #Path to the archive
        archive = archive()

        # OS path splits the name away from the file extension and path variable
        new_folder = os.path.splitext(archive)[0][0:]

        if name.endswith('.zip') or name.endswith('.ZIP'):
            extract('zip', archive, root)
            delete(archive)

        elif name.endswith('.rar') or name.endswith('.RAR'):
            extract('rar', archive, root)
            delete(archive)

        elif name.endswith('.cbr') or name.endswith('.CBR'):
            rename('rar', archive, root)
            delete(archive)

        elif name.endswith('.cbz') or name.endswith('.CBZ'):
            rename('zip', archive, root)
            delete(archive)
        
        else:
            print(name, " is not a folder")
