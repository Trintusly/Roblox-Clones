global.__GmnSetCompatabilityMode__ = external_define(temp_directory+"\Newton.dll","GmnSetCompatabilityMode",dll_stdcall,ty_real,1,ty_real);
global.__GmnGetCompatabilityMode__ = external_define(temp_directory+"\Newton.dll","GmnGetCompatabilityMode",dll_stdcall,ty_real,0);
global.__GmnSetGravity__ = external_define(temp_directory+"\Newton.dll","GmnSetGravity",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnCreateBody__ = external_define(temp_directory+"\Newton.dll","GmnCreateBody",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnDestroyBody__ = external_define(temp_directory+"\Newton.dll","GmnDestroyBody",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodyLinkObject__ = external_define(temp_directory+"\Newton.dll","GmnBodyLinkObject",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnBodyUnlinkObject__ = external_define(temp_directory+"\Newton.dll","GmnBodyUnlinkObject",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodyGetLinked__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetLinked",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodyGetLinkedObject__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetLinkedObject",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodyGetWorld__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetWorld",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodyGetCollision__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetCollision",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodySetMassMatrix__ = external_define(temp_directory+"\Newton.dll","GmnBodySetMassMatrix",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodySetForce__ = external_define(temp_directory+"\Newton.dll","GmnBodySetForce",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyAddForce__ = external_define(temp_directory+"\Newton.dll","GmnBodyAddForce",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyGetForce__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetForce",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetTorque__ = external_define(temp_directory+"\Newton.dll","GmnBodySetTorque",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyAddTorque__ = external_define(temp_directory+"\Newton.dll","GmnBodyAddTorque",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyGetTorque__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetTorque",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetAutoFreeze__ = external_define(temp_directory+"\Newton.dll","GmnBodySetAutoFreeze",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetAutoSleep__ = external_define(temp_directory+"\Newton.dll","GmnBodySetAutoSleep",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetMaterialGroupID__ = external_define(temp_directory+"\Newton.dll","GmnBodySetMaterialGroupID",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetContinuousCollisionMode__ = external_define(temp_directory+"\Newton.dll","GmnBodySetContinuousCollisionMode",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetJointRecursiveCollision__ = external_define(temp_directory+"\Newton.dll","GmnBodySetJointRecursiveCollision",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetVelocity__ = external_define(temp_directory+"\Newton.dll","GmnBodySetVelocity",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodySetVelocityAxis__ = external_define(temp_directory+"\Newton.dll","GmnBodySetVelocityAxis",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnBodyGetVelocity__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetVelocity",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetOmega__ = external_define(temp_directory+"\Newton.dll","GmnBodySetOmega",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodySetOmegaAxis__ = external_define(temp_directory+"\Newton.dll","GmnBodySetOmegaAxis",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnBodyGetOmega__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetOmega",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetLinearDamping__ = external_define(temp_directory+"\Newton.dll","GmnBodySetLinearDamping",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodyGetLinearDamping__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetLinearDamping",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodySetAngularDamping__ = external_define(temp_directory+"\Newton.dll","GmnBodySetAngularDamping",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyGetAngularDamping__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetAngularDamping",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodyAddImpulse__ = external_define(temp_directory+"\Newton.dll","GmnBodyAddImpulse",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodySetCentreOfMass__ = external_define(temp_directory+"\Newton.dll","GmnBodySetCentreOfMass",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodySetAutoMassMatrix__ = external_define(temp_directory+"\Newton.dll","GmnBodySetAutoMassMatrix",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnBodyAutoGetPosRot__ = external_define(temp_directory+"\Newton.dll","GmnBodyAutoGetPosRot",dll_stdcall,ty_real,1,ty_real);
global.__GmnBodyGetPosition__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetPosition",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodyGetRotation__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetRotation",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetPosition__ = external_define(temp_directory+"\Newton.dll","GmnBodySetPosition",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodySetRotation__ = external_define(temp_directory+"\Newton.dll","GmnBodySetRotation",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyGetPointGlobalVelocity__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetPointGlobalVelocity",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyGetPointLocalVelocity__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetPointLocalVelocity",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyAddPointGlobalForce__ = external_define(temp_directory+"\Newton.dll","GmnBodyAddPointGlobalForce",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyAddPointLocalForce__ = external_define(temp_directory+"\Newton.dll","GmnBodyAddPointLocalForce",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBodyGetLocalOmega__ = external_define(temp_directory+"\Newton.dll","GmnBodyGetLocalOmega",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__createBuoyancyDefine__ = external_define(temp_directory+"\Newton.dll","createBuoyancyDefine",dll_stdcall,ty_real,6,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialSetBuoyancyCallback__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetBuoyancyCallback",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateNull__ = external_define(temp_directory+"\Newton.dll","GmnCreateNull",dll_stdcall,ty_real,1,ty_real);
global.__GmnCreateBox__ = external_define(temp_directory+"\Newton.dll","GmnCreateBox",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateSphere__ = external_define(temp_directory+"\Newton.dll","GmnCreateSphere",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateCone__ = external_define(temp_directory+"\Newton.dll","GmnCreateCone",dll_stdcall,ty_real,6,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateCapsule__ = external_define(temp_directory+"\Newton.dll","GmnCreateCapsule",dll_stdcall,ty_real,6,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateCylinder__ = external_define(temp_directory+"\Newton.dll","GmnCreateCylinder",dll_stdcall,ty_real,6,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateChamferCylinder__ = external_define(temp_directory+"\Newton.dll","GmnCreateChamferCylinder",dll_stdcall,ty_real,6,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnConvexCollisionCalculateVolume__ = external_define(temp_directory+"\Newton.dll","GmnConvexCollisionCalculateVolume",dll_stdcall,ty_real,1,ty_real);
global.__GmnModelBufferClear__ = external_define(temp_directory+"\Newton.dll","GmnModelBufferClear",dll_stdcall,ty_real,0);
global.__GmnModelBufferAdd__ = external_define(temp_directory+"\Newton.dll","GmnModelBufferAdd",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnModelBufferCount__ = external_define(temp_directory+"\Newton.dll","GmnModelBufferCount",dll_stdcall,ty_real,0);
global.__GmnCreateConvexHull__ = external_define(temp_directory+"\Newton.dll","GmnCreateConvexHull",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBeginConstructCompoundCollision__ = external_define(temp_directory+"\Newton.dll","GmnBeginConstructCompoundCollision",dll_stdcall,ty_real,0);
global.__GmnConstructCompoundCollisionAdd__ = external_define(temp_directory+"\Newton.dll","GmnConstructCompoundCollisionAdd",dll_stdcall,ty_real,1,ty_real);
global.__GmnEndConstructCompoundCollision__ = external_define(temp_directory+"\Newton.dll","GmnEndConstructCompoundCollision",dll_stdcall,ty_real,1,ty_real);
global.__GmnReleaseCollision__ = external_define(temp_directory+"\Newton.dll","GmnReleaseCollision",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCollisionSetAsTriggerVolume__ = external_define(temp_directory+"\Newton.dll","GmnCollisionSetAsTriggerVolume",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomConstraintCreateRigid__ = external_define(temp_directory+"\Newton.dll","GmnCustomConstraintCreateRigid",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCustomConstraintCreateDryRollingFriction__ = external_define(temp_directory+"\Newton.dll","GmnCustomConstraintCreateDryRollingFriction",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnCreateCustomKinematicController__ = external_define(temp_directory+"\Newton.dll","GmnCreateCustomKinematicController",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnCustomKinematicControllerSetMaxAngularFriction__ = external_define(temp_directory+"\Newton.dll","GmnCustomKinematicControllerSetMaxAngularFriction",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomKinematicControllerSetMaxLinearFriction__ = external_define(temp_directory+"\Newton.dll","GmnCustomKinematicControllerSetMaxLinearFriction",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomKinematicControllerSetPickMode__ = external_define(temp_directory+"\Newton.dll","GmnCustomKinematicControllerSetPickMode",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomKinematicControllerSetTargetPosit__ = external_define(temp_directory+"\Newton.dll","GmnCustomKinematicControllerSetTargetPosit",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnCustomKinematicControllerSetTargetRotation__ = external_define(temp_directory+"\Newton.dll","GmnCustomKinematicControllerSetTargetRotation",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnConstraintCreateBall__ = external_define(temp_directory+"\Newton.dll","GmnConstraintCreateBall",dll_stdcall,ty_real,6,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnBallGetJointForce__ = external_define(temp_directory+"\Newton.dll","GmnBallGetJointForce",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBallGetJointForceMag__ = external_define(temp_directory+"\Newton.dll","GmnBallGetJointForceMag",dll_stdcall,ty_real,1,ty_real);
global.__GmnConstraintCreateUpVector__ = external_define(temp_directory+"\Newton.dll","GmnConstraintCreateUpVector",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnConstraintCreateHinge__ = external_define(temp_directory+"\Newton.dll","GmnConstraintCreateHinge",dll_stdcall,ty_real,9,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateCustomSlider__ = external_define(temp_directory+"\Newton.dll","GmnCreateCustomSlider",dll_stdcall,ty_real,8,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnSliderEnableLimits__ = external_define(temp_directory+"\Newton.dll","GmnSliderEnableLimits",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnSliderSetLimits__ = external_define(temp_directory+"\Newton.dll","GmnSliderSetLimits",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnDestroyJoint__ = external_define(temp_directory+"\Newton.dll","GmnDestroyJoint",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomDestroyJoint__ = external_define(temp_directory+"\Newton.dll","GmnCustomDestroyJoint",dll_stdcall,ty_real,1,ty_real);
global.__GmnJointSetCollisionState__ = external_define(temp_directory+"\Newton.dll","GmnJointSetCollisionState",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomJointSetCollisionState__ = external_define(temp_directory+"\Newton.dll","GmnCustomJointSetCollisionState",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCreateCustomHinge__ = external_define(temp_directory+"\Newton.dll","GmnCreateCustomHinge",dll_stdcall,ty_real,8,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCustomHingeSetLimits__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetLimits",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnCustomHingeGetForceMagnitude__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeGetForceMagnitude",dll_stdcall,ty_real,1,ty_real);
global.__GmnCustomHingeGetTorqueMagnitude__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeGetTorqueMagnitude",dll_stdcall,ty_real,1,ty_real);
global.__GmnCustomHingeSetSeverCallscript__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetSeverCallscript",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomHingeSetBreakCallscript__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetBreakCallscript",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomHingeSetSeverTolerance__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetSeverTolerance",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnCustomHingeSetSeverable__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetSeverable",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomHingeSetLimitsBreakTolerance__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetLimitsBreakTolerance",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomHingeSetLimitsBreakable__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeSetLimitsBreakable",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomHingeGetLimitsBreakTolerance__ = external_define(temp_directory+"\Newton.dll","GmnCustomHingeGetLimitsBreakTolerance",dll_stdcall,ty_real,1,ty_real);
global.__GmnCreateCustomRigid__ = external_define(temp_directory+"\Newton.dll","GmnCreateCustomRigid",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCustomRigidGetForceMagnitude__ = external_define(temp_directory+"\Newton.dll","GmnCustomRigidGetForceMagnitude",dll_stdcall,ty_real,1,ty_real);
global.__GmnCustomRigidGetTorqueMagnitude__ = external_define(temp_directory+"\Newton.dll","GmnCustomRigidGetTorqueMagnitude",dll_stdcall,ty_real,1,ty_real);
global.__GmnCustomRigidSetSeverCallscript__ = external_define(temp_directory+"\Newton.dll","GmnCustomRigidSetSeverCallscript",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomRigidSetSeverTolerance__ = external_define(temp_directory+"\Newton.dll","GmnCustomRigidSetSeverTolerance",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnCustomRigidSetSeverable__ = external_define(temp_directory+"\Newton.dll","GmnCustomRigidSetSeverable",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCreateCustomRigid__ = external_define(temp_directory+"\Newton.dll","GmnCreateCustomRigid",dll_stdcall,ty_real,9,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnCreateCustomPlayerController__ = external_define(temp_directory+"\Newton.dll","GmnCreateCustomPlayerController",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnCustomPlayerControllerSetMaxSlope__ = external_define(temp_directory+"\Newton.dll","GmnCustomPlayerControllerSetMaxSlope",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCustomPlayerControllerSetVelocity__ = external_define(temp_directory+"\Newton.dll","GmnCustomPlayerControllerSetVelocity",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialGetDefaultGroupID__ = external_define(temp_directory+"\Newton.dll","GmnMaterialGetDefaultGroupID",dll_stdcall,ty_real,1,ty_real);
global.__GmnMaterialCreateGroupId__ = external_define(temp_directory+"\Newton.dll","GmnMaterialCreateGroupId",dll_stdcall,ty_real,1,ty_real);
global.__GmnMaterialDestroyAllGroupID__ = external_define(temp_directory+"\Newton.dll","GmnMaterialDestroyAllGroupID",dll_stdcall,ty_real,1,ty_real);
global.__GmnMaterialSetDefaultCollidable__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetDefaultCollidable",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialSetContinuousCollisionMode__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetContinuousCollisionMode",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialSetDefaultFriction__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetDefaultFriction",dll_stdcall,ty_real,5,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialSetDefaultElasticity__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetDefaultElasticity",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialSetDefaultSoftness__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetDefaultSoftness",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnMaterialSetCollisionCallback__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetCollisionCallback",dll_stdcall,ty_real,3,ty_real,ty_real,ty_real);
global.__GmnMaterialSetResponseType__ = external_define(temp_directory+"\Newton.dll","GmnMaterialSetResponseType",dll_stdcall,ty_real,4,ty_real,ty_real,ty_real,ty_real);
global.__GmnCollisionGet__ = external_define(temp_directory+"\Newton.dll","GmnCollisionGet",dll_stdcall,ty_real,0);
global.__GmnCollisionGetNext__ = external_define(temp_directory+"\Newton.dll","GmnCollisionGetNext",dll_stdcall,ty_real,1,ty_real);
global.__GmnCollisionGetObject__ = external_define(temp_directory+"\Newton.dll","GmnCollisionGetObject",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCollisionGetContactCount__ = external_define(temp_directory+"\Newton.dll","GmnCollisionGetContactCount",dll_stdcall,ty_real,1,ty_real);
global.__GmnCollisionGetMaxImpactSpeed__ = external_define(temp_directory+"\Newton.dll","GmnCollisionGetMaxImpactSpeed",dll_stdcall,ty_real,1,ty_real);
global.__GmnCreateTreeCollision__ = external_define(temp_directory+"\Newton.dll","GmnCreateTreeCollision",dll_stdcall,ty_real,1,ty_real);
global.__GmnTreeCollisionBeginBuild__ = external_define(temp_directory+"\Newton.dll","GmnTreeCollisionBeginBuild",dll_stdcall,ty_real,1,ty_real);
global.__GmnTreeCollisionAddFace__ = external_define(temp_directory+"\Newton.dll","GmnTreeCollisionAddFace",dll_stdcall,ty_real,11,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnTreeCollisionEndBuild__ = external_define(temp_directory+"\Newton.dll","GmnTreeCollisionEndBuild",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnCreate__ = external_define(temp_directory+"\Newton.dll","GmnCreate",dll_stdcall,ty_real,0);
global.__GmnDestroy__ = external_define(temp_directory+"\Newton.dll","GmnDestroy",dll_stdcall,ty_real,1,ty_real);
global.__GmnSetPlatformArchitecture__ = external_define(temp_directory+"\Newton.dll","GmnSetPlatformArchitecture",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnSetSolverModel__ = external_define(temp_directory+"\Newton.dll","GmnSetSolverModel",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnSetFrictionModel__ = external_define(temp_directory+"\Newton.dll","GmnSetFrictionModel",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnUpdateFPS__ = external_define(temp_directory+"\Newton.dll","GmnUpdateFPS",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnUpdate__ = external_define(temp_directory+"\Newton.dll","GmnUpdate",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnSetMinimumFrameRate__ = external_define(temp_directory+"\Newton.dll","GmnSetMinimumFrameRate",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnGetTimeStep__ = external_define(temp_directory+"\Newton.dll","GmnGetTimeStep",dll_stdcall,ty_real,1,ty_real);
global.__GmnDestroyAllBodies__ = external_define(temp_directory+"\Newton.dll","GmnDestroyAllBodies",dll_stdcall,ty_real,1,ty_real);
global.__GmnSetWorldSize__ = external_define(temp_directory+"\Newton.dll","GmnSetWorldSize",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnWorldFreezeBody__ = external_define(temp_directory+"\Newton.dll","GmnWorldFreezeBody",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnWorldUnfreezeBody__ = external_define(temp_directory+"\Newton.dll","GmnWorldUnfreezeBody",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnBodySetFreezeState__ = external_define(temp_directory+"\Newton.dll","GmnBodySetFreezeState",dll_stdcall,ty_real,2,ty_real,ty_real);
global.__GmnWorldGetBodyCount__ = external_define(temp_directory+"\Newton.dll","GmnWorldGetBodyCount",dll_stdcall,ty_real,1,ty_real);
global.__GmnWorldRayCastDist__ = external_define(temp_directory+"\Newton.dll","GmnWorldRayCastDist",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
global.__GmnWorldRayCastObject__ = external_define(temp_directory+"\Newton.dll","GmnWorldRayCastObject",dll_stdcall,ty_real,7,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real,ty_real);
/*nf("GmnSetCompatabilityMode",1);
nf("GmnGetCompatabilityMode",0);
nf("GmnSetGravity",3);
nf("GmnCreateBody",2);
nf("GmnDestroyBody",2);
nf("GmnBodyLinkObject",3);
nf("GmnBodyUnlinkObject",1);
nf("GmnBodyGetLinked",1);
nf("GmnBodyGetLinkedObject",1);
nf("GmnBodyGetWorld",1);
nf("GmnBodyGetCollision",1);
nf("GmnBodySetMassMatrix",5);
nf("GmnBodySetForce",4);
nf("GmnBodyAddForce",4);
nf("GmnBodyGetForce",2);
nf("GmnBodySetTorque",4);
nf("GmnBodyAddTorque",4);
nf("GmnBodyGetTorque",2);
nf("GmnBodySetAutoFreeze",2);
nf("GmnBodySetAutoSleep",2);
nf("GmnBodySetMaterialGroupID",2);
nf("GmnBodySetContinuousCollisionMode",2);
nf("GmnBodySetJointRecursiveCollision",2);
nf("GmnBodySetVelocity",4);
nf("GmnBodySetVelocityAxis",3);
nf("GmnBodyGetVelocity",2);
nf("GmnBodySetOmega",4);
nf("GmnBodySetOmegaAxis",3);
nf("GmnBodyGetOmega",2);
nf("GmnBodySetLinearDamping",2);
nf("GmnBodyGetLinearDamping",1);
nf("GmnBodySetAngularDamping",4);
nf("GmnBodyGetAngularDamping",2);
nf("GmnBodyAddImpulse",7);
nf("GmnBodySetCentreOfMass",4);
nf("GmnBodySetAutoMassMatrix",3);
nf("GmnBodyAutoGetPosRot",1);
nf("GmnBodyGetPosition",2);
nf("GmnBodyGetRotation",2);
nf("GmnBodySetPosition",4);
nf("GmnBodySetRotation",4);
nf("GmnBodyGetPointGlobalVelocity",5);
nf("GmnBodyGetPointLocalVelocity",5);
nf("GmnBodyAddPointGlobalForce",7);
nf("GmnBodyAddPointLocalForce",7);
nf("GmnBodyGetLocalOmega",2);
nf("createBuoyancyDefine",6);
nf("GmnMaterialSetBuoyancyCallback",5);
nf("GmnCreateNull",1);
nf("GmnCreateBox",7);
nf("GmnCreateSphere",7);
nf("GmnCreateCone",6);
nf("GmnCreateCapsule",6);
nf("GmnCreateCylinder",6);
nf("GmnCreateChamferCylinder",6);
nf("GmnConvexCollisionCalculateVolume",1);
nf("GmnModelBufferClear",0);
nf("GmnModelBufferAdd",3);
nf("GmnModelBufferCount",0);
nf("GmnCreateConvexHull",5);
nf("GmnBeginConstructCompoundCollision",0);
nf("GmnConstructCompoundCollisionAdd",1);
nf("GmnEndConstructCompoundCollision",1);
nf("GmnReleaseCollision",2);
nf("GmnCollisionSetAsTriggerVolume",2);
nf("GmnCustomConstraintCreateRigid",5);
nf("GmnCustomConstraintCreateDryRollingFriction",3);
nf("GmnCreateCustomKinematicController",4);
nf("GmnCustomKinematicControllerSetMaxAngularFriction",2);
nf("GmnCustomKinematicControllerSetMaxLinearFriction",2);
nf("GmnCustomKinematicControllerSetPickMode",2);
nf("GmnCustomKinematicControllerSetTargetPosit",4);
nf("GmnCustomKinematicControllerSetTargetRotation",4);
nf("GmnConstraintCreateBall",6);
nf("GmnBallGetJointForce",2);
nf("GmnBallGetJointForceMag",1);
nf("GmnConstraintCreateUpVector",5);
nf("GmnConstraintCreateHinge",9);
nf("GmnCreateCustomSlider",8);
nf("GmnSliderEnableLimits",2);
nf("GmnSliderSetLimits",3);
nf("GmnDestroyJoint",2);
nf("GmnCustomDestroyJoint",1);
nf("GmnJointSetCollisionState",2);
nf("GmnCustomJointSetCollisionState",2);
nf("GmnCreateCustomHinge",8);
nf("GmnCustomHingeSetLimits",3);
nf("GmnCustomHingeGetForceMagnitude",1);
nf("GmnCustomHingeGetTorqueMagnitude",1);
nf("GmnCustomHingeSetSeverCallscript",2);
nf("GmnCustomHingeSetBreakCallscript",2);
nf("GmnCustomHingeSetSeverTolerance",3);
nf("GmnCustomHingeSetSeverable",2);
nf("GmnCustomHingeSetLimitsBreakTolerance",2);
nf("GmnCustomHingeSetLimitsBreakable",2);
nf("GmnCustomHingeGetLimitsBreakTolerance",1);
nf("GmnCreateCustomRigid",5);
nf("GmnCustomRigidGetForceMagnitude",1);
nf("GmnCustomRigidGetTorqueMagnitude",1);
nf("GmnCustomRigidSetSeverCallscript",2);
nf("GmnCustomRigidSetSeverTolerance",3);
nf("GmnCustomRigidSetSeverable",2);
nf("GmnCreateCustomRigid",9);
nf("GmnCreateCustomPlayerController",3);
nf("GmnCustomPlayerControllerSetMaxSlope",2);
nf("GmnCustomPlayerControllerSetVelocity",4);
nf("GmnMaterialGetDefaultGroupID",1);
nf("GmnMaterialCreateGroupId",1);
nf("GmnMaterialDestroyAllGroupID",1);
nf("GmnMaterialSetDefaultCollidable",4);
nf("GmnMaterialSetContinuousCollisionMode",4);
nf("GmnMaterialSetDefaultFriction",5);
nf("GmnMaterialSetDefaultElasticity",4);
nf("GmnMaterialSetDefaultSoftness",4);
nf("GmnMaterialSetCollisionCallback",3);
nf("GmnMaterialSetResponseType",4);
nf("GmnCollisionGet",0);
nf("GmnCollisionGetNext",1);
nf("GmnCollisionGetObject",2);
nf("GmnCollisionGetContactCount",1);
nf("GmnCollisionGetMaxImpactSpeed",1);
nf("GmnCreateTreeCollision",1);
nf("GmnTreeCollisionBeginBuild",1);
nf("GmnTreeCollisionAddFace",11);
nf("GmnTreeCollisionEndBuild",2);
nf("GmnCreate",0);
nf("GmnDestroy",1);
nf("GmnSetPlatformArchitecture",2);
nf("GmnSetSolverModel",2);
nf("GmnSetFrictionModel",2);
nf("GmnUpdateFPS",2);
nf("GmnUpdate",2);
nf("GmnSetMinimumFrameRate",2);
nf("GmnGetTimeStep",1);
nf("GmnDestroyAllBodies",1);
nf("GmnSetWorldSize",7);
nf("GmnWorldFreezeBody",2);
nf("GmnWorldUnfreezeBody",2);
nf("GmnBodySetFreezeState",2);
nf("GmnWorldGetBodyCount",1);
nf("GmnWorldRayCastDist",7);
nf("GmnWorldRayCastObject",7);
