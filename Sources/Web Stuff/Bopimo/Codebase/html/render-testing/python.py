import bpy
import struct
from bpy import context

def hex_to_rgb(rgb_str):    
    int_tuple = struct.unpack('BBB', bytes.fromhex(rgb_str))    
    return tuple([val/255 for val in int_tuple])
# BOPIMO RENDERER SCRIPT
bpy.ops.wm.open_mainfile(filepath="/var/www/html/render-testing/2bopimoavatar.blend")
bpy.data.objects[Head].select = True
bpy.data.objects[Head].active_material.diffuse_color = hex_to_rgb(071d3f)
#Render Section
bpy.data.scenes['Scene'].render.filepath = '/var/www/html/render-testing/5b1b495997ce3.png'
bpy.ops.object.select_all(action='SELECT')
bpy.ops.view3d.camera_to_view_selected()
bpy.ops.render.render( write_still=True )
#file rendered: 5b1b495997ce3.png