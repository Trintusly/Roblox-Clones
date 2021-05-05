

import bpy
bpy.ops.wm.open_mainfile(filepath="/var/www/html/render/BPRAvatar.blend")


hatpath = "/var/www/html/render/models/hats/1.obj"
import_hat = bpy.ops.import_scene.obj(filepath=hatpath)
hat = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat"
hatImg = bpy.data.images.load(filepath="/var/www/html/render/textures/hats/1.png")
hatTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
hatTex.image = hatImg
hatMat = bpy.data.materials.new("MaterialName")
hatMat.diffuse_shader = "LAMBERT"

hatSlot = hatMat.texture_slots.add()
hatSlot.texture = hatTex
hat.active_material = hatMat





HeadImg = bpy.data.images.load(filepath="/var/www/html/render/textures/faces/19.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex




bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 118/255, 182/255)

bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (255/255, 173/255, 96/255)

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (255/255, 173/255, 96/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (255/255, 173/255, 96/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (0/255, 0/255, 0/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (0/255, 0/255, 0/255)


for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "/var/www/html/storage/avatars/375.png"
bpy.ops.render.render( write_still=True )

