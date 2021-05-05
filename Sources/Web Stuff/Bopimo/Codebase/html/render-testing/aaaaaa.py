import bpy
import struct
from bpy import context
from mathutils import Euler
import math
def hex_to_rgb(value):
    gamma = 2.05
    value = value.lstrip('#')
    lv = len(value)
    fin = list(int(value[i:i + lv // 3], 16) for i in range(0, lv, lv // 3))
    r = pow(fin[0] / 255, gamma)
    g = pow(fin[1] / 255, gamma)
    b = pow(fin[2] / 255, gamma)
    fin.clear()
    fin.append(r)
    fin.append(g)
    fin.append(b)
    return tuple(fin)

bpy.ops.wm.open_mainfile(filepath='/var/www/html/render-testing/tools.blend')
bpy.ops.import_scene.obj(filepath='/var/www/storage/assets/tools/1732.obj')
tool = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].name = 'tool'
tool.data.materials.clear()
tool_Mat = bpy.data.materials.new(name='tool_Mat')
tool_Tex = bpy.data.textures.new(name='tool_Tex',type='IMAGE')
tool_Tex_Image = bpy.data.images.load(filepath = '/var/www/storage/assets/tools/1732.png')
bpy.data.textures['tool_Tex'].image = tool_Tex_Image
tool_Slot = tool_Mat.texture_slots.add()
tool_Slot.texture = tool_Tex
tool.data.materials.append(tool_Mat)
for obj in bpy.data.objects:
    obj.select = False
bpy.data.objects['tool'].select = True
bpy.ops.view3d.camera_to_view_selected()
scene = bpy.data.scenes['Scene']
scene.render.resolution_x = 250
scene.render.resolution_y = 250
scene.render.resolution_percentage = 100
#Render Section
bpy.data.scenes['Scene'].render.filepath = '/var/www/html/render-testing/aaaaaa.png'
bpy.ops.render.render( write_still=True )
#file rendered: /var/www/html/render-testing/aaaaaa.png
#CREATED: /var/www/html/render-testing/aaaaaa.py